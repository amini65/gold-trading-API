<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        "gold_balance",
        "user_id",
        "currency_balance",
    ];

    protected $casts = [
      "amount" => "double"
    ];
}
