<?php

namespace App\Services\Contracts;

use App\Models\Order;


interface MatchingServiceInterface
{
    public function findMatchingOrders(Order $order);
}
