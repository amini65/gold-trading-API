<?php

namespace App\Rules;

use App\Repositories\Repos\WalletRepo;
use App\Traits\CommissionTrait;
use Closure;
use Illuminate\Contracts\Validation\Rule;

class CheckWalletPrice implements Rule
{

    use CommissionTrait;

    public function __construct(private $request)
    {

    }

    public function passes($attribute, $value)
    {
        $userWallet=app(WalletRepo::class)->checkUserWallet($this->request);
        $commission= $this->calculateCommission($this->request->amount,$this->request->price);
//        dd($commission);
        if($this->request->order_type =='buy'){
            if($userWallet->currency_balance > ($this->request->price*$this->request->amount)+$commission['priceCommission']){
                return true;
            }
            return false;
        }
        return true;

    }

    public function message()
    {
        return 'you don\'t have enough :attribute .';
    }
}
