<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\TradeService;


class OrderObserver
{
    public function created(Order $order)
    {
        app(TradeService::class)->addTrade($order);
    }
}
