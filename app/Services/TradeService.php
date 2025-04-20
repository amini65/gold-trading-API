<?php

namespace App\Services;


use App\Models\Order;
use App\Repositories\Contracts\TradeRepositoryInterface;
use App\Repositories\Repos\WalletRepo;
use App\Services\Contracts\MatchingServiceInterface;
use App\Services\Contracts\OrderServiceInterface;
use App\Services\Contracts\WalletServiceInterface;
use App\Traits\CommissionTrait;
use Illuminate\Support\Facades\DB;

class TradeService
{
    use CommissionTrait;

    private $walletRepo;
    public function __construct(
        private MatchingServiceInterface $matchingService,
        private WalletServiceInterface $walletService,
        private OrderServiceInterface $orderService,
        private TradeRepositoryInterface $tradeRepository,
        WalletRepo $walletRepo

    )
    {
        $this->walletRepo=$walletRepo;
    }


    public function addTrade(Order $order)
    {

        DB::beginTransaction();
        try {

            $commission=$this->walletService->depositWallet($order);

            $this->orderService->setOrderCommissionRateAndRemaining($order,$commission['rateCommission']);

            $matchingOrders =$this->matchingService->findMatchingOrders($order);

            foreach ($matchingOrders as $matchingOrder) {
                if ($order->remaining_amount <= 0) {
                    break;
                }

                 $this->executeTrade($order, $matchingOrder);


            }

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }


    }

    public function executeTrade($order, $matchingOrder)
    {
        $remaining=$this->orderService->calculateOrderRemaining($order,$matchingOrder);

        $this->tradeRepository->create($order,$matchingOrder,$remaining['diff_remaining_amount']);

        $this->walletService->addWallet($order,$matchingOrder,$remaining['diff_remaining_amount']);

        if($remaining['order_amount']==0){
            $this->orderService->setCompleteOrder($order,$remaining['diff_remaining_amount']);
        }

        if($remaining['matching_amount']==0){
            $this->orderService->setCompleteOrder($matchingOrder,$remaining['diff_remaining_amount']);
        }


        $this->orderService->updateOrderRemaining($order,$remaining['order_amount']);
        $this->orderService->updateOrderRemaining($matchingOrder,$remaining['matching_amount']);

    }

    public function cancelTrade(Order $order)
    {

        DB::beginTransaction();

     try {

         $this->orderService->freezeOrderBalance($order);

         $commission=$this->walletService->releaseWallet($order);

         $this->orderService->setCancelOrder($order ,$commission);

        DB::commit();
        return $order;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

}
