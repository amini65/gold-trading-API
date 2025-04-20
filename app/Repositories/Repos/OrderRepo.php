<?php

namespace App\Repositories\Repos;

use App\Enums\OrderStatusEnum;
use App\Http\Requests\UserOrderRequest;
use App\Models\Order;
use App\Models\User;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderRepo implements OrderRepositoryInterface
{
    private $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function getAllWithPagination(Request $request)
    {
        $perPage = $request->get("per_page") ?? 15;
        $relations = $request->get("relations") ?? [];
        $orderBy = $request->get("order_by") ?? "DESC";
        return $this->model
            ->query()
            ->filter($request)
            ->orderBy("id", $orderBy)
            ->with($relations)
            ->paginate($perPage);
    }

    public function getAllUserOrder(User $user ,Request $request)
    {
        $perPage = $request->get("per_page") ?? 15;
        $orderBy = $request->get("order_by") ?? "DESC";

        return $this->model
            ->query()
            ->where('user_id',$user->id)
            ->filter($request)
            ->orderBy("id", $orderBy)
            ->paginate($perPage);
    }

    /**
     * @inheritDoc
     */
    public function store(array $inputs): mixed
    {
        $inputs['remaining_amount'] = $inputs['amount'];
        return $this->model
            ->newQuery()
            ->create($inputs);
    }

    public function findOrders($order)
    {
        return Order::query()
            ->where("price" , $order['price'])
            ->where("amount" ,'>',0)
            ->where("order_type" , "!=" , $order['order_type'])
            ->whereIn("order_status"  , ["open" , "partial"])
//        ->orderBy('price', $orderType === 'buy' ? 'asc' : 'desc')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function updateCommissionRateAndRemaining(Order $order, $commissionRate):void
    {
        $order->update([
            'commission_rate' => $commissionRate,
            'remaining_amount' => $order->amount,
        ]);

    }

    public function freezeOrder(Order $order)
    {
        $this->model
            ->where('id',  $order->id)
            ->lockForUpdate()
            ->first();
    }

    public function updateOrderRemaining(Order $order ,$orderRemaining)
    {
        $order->update([
                'remaining_amount' =>$orderRemaining
            ]
        );
    }

    public function setCompleteOrder(Order $order, $orderCommission)
    {
        $order->update([
                'order_status' =>OrderStatusEnum::COMPLETED->value,
                'commission' =>$orderCommission,
            ]
        );
    }

    public function setCancelOrder(Order $order, $commission)
    {
        $order->update([
            'order_status' => OrderStatusEnum::CANCELLED->value,
            'commission' =>$commission,
        ]);
    }

}
