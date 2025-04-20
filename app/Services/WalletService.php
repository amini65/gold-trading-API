<?php

namespace App\Services;


use App\Enums\OrderTypeEnum;
use App\Models\Order;
use App\Repositories\Contracts\WalletRepositoryInterface;
use App\Services\Contracts\WalletServiceInterface;
use App\Traits\CommissionTrait;

class WalletService implements WalletServiceInterface
{

    use CommissionTrait;

    public function __construct(
        private WalletRepositoryInterface $walletRepository
    )
    {}

    public function depositWallet(Order $order)
    {
        $commission= $this->calculateCommission($order->amount,$order->price);

        $wallet=$this->walletRepository->getUserWallet($order->user_id);

        if($order->order_type == OrderTypeEnum::BUY->value){
            $wallet->decrement('currency_balance',($order->price * $order->amount)+$commission['priceCommission']);
        }else{
            $wallet->decrement('gold_balance', $order->amount);
        }

        return $commission;
    }


    public function addWallet(Order $order, Order $matchingOrder, $diffRemaining)
    {
        if ($order->order_type == OrderTypeEnum::SELL->value)  {
            $this->addWalletSeller($order,$diffRemaining);
            $this->addWalletBuyer($matchingOrder,$diffRemaining);
        } else {
            $this->addWalletSeller($matchingOrder,$diffRemaining);
            $this->addWalletBuyer($order,$diffRemaining);
        }
    }


    public function addWalletBuyer(Order $order,$diffRemaining): void
    {

        $wallet=$this->walletRepository->getUserWallet($order->user_id);

        $wallet->increment('gold_balance', $diffRemaining);
    }

    public function addWalletSeller(Order $order,$diffRemaining): void
    {

        $wallet=$this->walletRepository->getUserWallet($order->user_id);

        $wallet->increment('currency_balance',$diffRemaining * $order->price);
    }

    public function releaseWallet(Order $order)
    {
        $wallet=$this->walletRepository->getUserWallet($order->user_id);

        if ($order->order_type == OrderTypeEnum::BUY->value) {
            $commission=$this->releaseBuyer($order,$wallet);

        } else {
            $commission=$this->releaseSeller($order,$wallet);
        }

        return $commission;
    }

    public function releaseBuyer(Order $order,$wallet)
    {
        $diffAmount=$order->amount - $order->remaining_amount;

        if($diffAmount>0){
            $commission= $this->calculateCommission($diffAmount, $order->price,$order->commission_rate);
            $wallet->decrement('currency_balance',$commission['priceCommission']);
            $wallet->increment('gold_balance',$diffAmount);

            return $commission['priceCommission'];
        }

        return 0;

    }

    public function releaseSeller(Order $order,$wallet)
    {

        $diffAmount=$order->amount - $order->remaining_amount;

        if($diffAmount>0){
            $commission= $this->calculateCommission($diffAmount, $order->price,$order->commission_rate);

            $wallet->decrement('currency_balance',$commission['priceCommission']);
            $wallet->increment('gold_balance',$order->remaining_amount);
            return $commission['priceCommission'];
        }
        return 0;

    }

}
