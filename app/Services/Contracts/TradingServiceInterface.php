<?php

namespace App\Services\Contracts;

use App\Models\Order;

interface TradingServiceInterface
{


    public function createTrade(Order $order, Order $matchingOrder,$diffRemaining);
 }
