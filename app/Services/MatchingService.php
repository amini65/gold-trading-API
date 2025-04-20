<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\Contracts\MatchingServiceInterface;

class MatchingService implements MatchingServiceInterface
{


    public function __construct(
        private OrderRepositoryInterface $orderRepository
    )
    {}

    public function findMatchingOrders(Order $order)
    {
        return $this->orderRepository->findOrders($order);
    }
}
