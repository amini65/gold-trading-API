<?php

namespace App\Services\Contracts;

use App\Models\Order;

interface OrderServiceInterface
{


    public function setOrderCommissionRateAndRemaining(Order $order,$commissionRate);

    public function calculateOrderRemaining(Order $order,Order $matchingOrder);

    public function setCompleteOrder(Order $order,$diffRemaining);
    public function updateOrderRemaining(Order $order,$orderRemaining);
    public function freezeOrderBalance(Order $order);

    public function setCancelOrder(Order $order,$commission);
}
