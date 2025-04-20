<?php

namespace App\Repositories\Repos;

use App\Models\Order;
use App\Models\Wallet;
use App\Repositories\Contracts\WalletRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletRepo implements WalletRepositoryInterface
{

    private $model;

    public function __construct(Wallet $model)
    {
        $this->model = $model;
    }

    public function getUserWallet($userId)
    {
        return $this->model
            ->query()
            ->where('user_id',$userId)
            ->firstOrFail();
    }

    public function checkUserWallet(Request $request): mixed
    {
        return $this->model
            ->query()
            ->where('user_id',$request->get("user_id"))
            ->firstOrFail();
    }


}
