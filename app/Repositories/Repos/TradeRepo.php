<?php

namespace App\Repositories\Repos;

use App\Models\Order;
use App\Models\Trade;
use App\Repositories\Contracts\TradeRepositoryInterface;

class TradeRepo implements TradeRepositoryInterface
{
    private $model;

    public function __construct(Trade $model)
    {
        $this->model = $model;
    }

    public function create(Order $order, Order $matchingOrder, $diffRemaining)
    {
        $this->model->query()->create([
        'seller_id' => $order->order_type === 'sell' ? $order->user_id : $matchingOrder->user_id,
        'buyer_id' => $order->order_type === 'buy' ? $order->user_id : $matchingOrder->user_id,
        'seller_order_id' => $order->order_type === 'buy' ? $matchingOrder->id : $order->id,
        'buyer_order_id' => $order->order_type === 'buy' ? $order->id : $matchingOrder->id,
        'amount' => $diffRemaining,
        'price' =>$order->price
    ]);
    }
}
