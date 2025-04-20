<?php

namespace App\Repositories\Contracts;

use App\Models\Order;

interface TradeRepositoryInterface
{

    public function create(Order $order, Order $matchingOrder,$diffRemaining);


}
