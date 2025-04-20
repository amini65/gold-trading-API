<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\UserOrderRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

interface OrderRepositoryInterface
{

    public function getAllWithPagination(Request $request);

    /**
     * @param array $inputs
     * @return mixed
     */
    public function store(array $inputs): mixed;
    public function getAllUserOrder(User $userId,Request $request);
    public function findOrders(Order $order);
    public function updateCommissionRateAndRemaining(Order $order,$commissionRate):void;

    public function freezeOrder(Order $order);
    public function updateOrderRemaining(Order $order,$orderRemaining);
    public function setCompleteOrder(Order $order,$orderCommission);
    public function setCancelOrder(Order $order,$commission);

}
