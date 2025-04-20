<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\UserOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\TradeService;
use App\Traits\CommissionTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ResponseTrait;

    private OrderRepositoryInterface $orderRepository;
    public function __construct( OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }


    public function index(Request $request)
    {
        $result = OrderResource::collection($this->orderRepository->getAllWithPagination($request));
        return $this->successResponse($result , 200,null , $result->response()->getData()->meta);
    }

    public function show(Order $order , Request $request)
    {
        $order->load($request->get('relations'));

        return $this->successResponse(new OrderResource($order));
    }
    public function history(User $user,Request $request)
    {
        $orders = $this->orderRepository->getAllUserOrder($user,$request);

        return $this->successResponse(OrderResource::collection($orders));


    }


    public function store(OrderRequest $request)
    {

        $result = $this->orderRepository->store($request->validated());
        return $this->successResponse(new OrderResource($result) , 201 , "order created");
    }

    public function cancelled(Order $order,TradeService  $tradeService)
    {

        try {

            if ($order->order_status !== OrderStatusEnum::OPEN->value) {
                return $this->errorResponse('Only open orders can be cancelled');
            }

            $tradeService->cancelTrade($order);;
            return $this->successResponse('', 200 , "Order cancelled successfully");

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }


    }


}
