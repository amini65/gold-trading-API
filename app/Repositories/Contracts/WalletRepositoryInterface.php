<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Http\Request;

interface WalletRepositoryInterface
{

    public function getUserWallet($userId);
    public function checkUserWallet(Request $request);


}
