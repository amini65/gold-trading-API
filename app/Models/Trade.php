<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $fillable = [
        "seller_id",
        "buyer_id",
        "seller_order_id",
        "buyer_order_id",
        "amount",
        "price",

    ];
}
