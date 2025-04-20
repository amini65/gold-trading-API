<?php

namespace App\Services;


use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\Contracts\OrderServiceInterface;
use App\Traits\CommissionTrait;

class OrderService implements OrderServiceInterface
{

    use CommissionTrait;
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
    )
    {}

    public function setOrderCommissionRateAndRemaining(Order $order, $commissionRate)
    {
        $this->orderRepository->updateCommissionRateAndRemaining($order, $commissionRate);
    }

    public function calculateOrderRemaining(Order $order, Order $matchingOrder)
    {
        $orderRemaining = ($order->remaining_amount - $matchingOrder->remaining_amount > 0)?$order->remaining_amount - $matchingOrder->remaining_amount:0;
        $matchingRemaining =( $matchingOrder->remaining_amount - $order->remaining_amount > 0)? $matchingOrder->remaining_amount - $order->remaining_amount:0;
        $diffRemaining=$order->remaining_amount -$orderRemaining;
        return array(
            'order_amount'=>$orderRemaining,
            'matching_amount'=>$matchingRemaining,
            'diff_remaining_amount'=>$diffRemaining,
        );
    }

    public function setCompleteOrder(Order $order, $diffRemaining)
    {
        $orderCommission = $this->calculateCommission($diffRemaining , $order->price,$order->commission_rate);
        $this->orderRepository->setCompleteOrder($order, $orderCommission['priceCommission']);
    }

    public function updateOrderRemaining(Order $order, $orderRemaining)
    {
        $this->orderRepository->updateOrderRemaining($order, $orderRemaining);
    }

    public function freezeOrderBalance(Order $order):void
    {
        $this->orderRepository->freezeOrder($order);
    }

    public function setCancelOrder(Order $order, $commission):void
    {
        $this->orderRepository->setCancelOrder($order, $commission);

    }
}
