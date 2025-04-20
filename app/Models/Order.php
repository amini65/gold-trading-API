<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        "user_id",
        "order_type",
        "order_status",
        "amount",
        "price",
        "commission_rate",
        "commission",
        "remaining_amount",

    ];

    /**
     * @param $query
     * @param $request
     * @return mixed
     */
    public function scopeFilter($query , $request)
    {
        return $query->when($request->get("user_id"), function ($q, $user_id) {
            $q->where("user_id", $user_id);
            })
            ->when($request->get("order_status"), function ($q, $status) {
                $q->where("order_status", $status);
            })
            ->when($request->get("order_type"), function ($q, $type) {
                $q->where("order_type", $type);
            })
            ->when($request->get("start_amount"), function ($q, $startAmount) {
                $q->where("amount", ">=", $startAmount);
            })
            ->when($request->get("end_amount"), function ($q, $endAmount) {
                $q->where("amount", "<=", $endAmount);
            })
            ->when($request->get("start_remain"), function ($q, $startRemain) {
                $q->where("remaining_amount", ">=", $startRemain);
            })
            ->when($request->get("end_remain"), function ($q, $endRemain) {
                $q->where("remaining_amount", "<=", $endRemain);
            })
            ->when($request->get("start_date"), function ($q, $startDate) {
                $q->where("created_at", ">=", $startDate);
            })
            ->when($request->get("end_date"), function ($q, $endDate) {
                $q->where("created_at", "<=", $endDate);
            });
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
