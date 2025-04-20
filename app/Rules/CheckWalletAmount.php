<?php

namespace App\Rules;

use App\Repositories\Repos\WalletRepo;
use Closure;
use Illuminate\Contracts\Validation\Rule;

class CheckWalletAmount implements Rule
{


    public function __construct(private $request)
    {

    }

    public function passes($attribute, $value)
    {

        $userWallet=app(WalletRepo::class)->checkUserWallet($this->request);

        if($this->request->order_type =='sell'){

            if($userWallet->gold_balance >= $this->request->amount){
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
