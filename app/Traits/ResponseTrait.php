<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    /**
     * @param $data
     * @param $code
     * @param $message
     * @return JsonResponse
     */
    public function successResponse($data = null, $code = 200 , $message = null , $paginate = null): JsonResponse
    {
        return response()->json([
            "status" => true,
            "data" => $data,
            "message" => $message,
            "paginate" => $paginate,
        ] , $code);
    }

    /**
     * @param $code
     * @param $message
     * @return JsonResponse
     */
    public function errorResponse($message = null ,  $code = 400 ): JsonResponse
    {
        return response()->json([
            "status" => false,
            "data" => null,
            "message" => $message,
        ] , $code);
    }
}
