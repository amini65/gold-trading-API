<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 *
 */
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "user" => $this->whenLoaded("user"),
            "order_type" => $this->order_type,
            "order_status" => $this->order_status,
            "amount" => $this->amount,
            "price" => $this->price/10,
            "currency_type" => $this->currency_type,
            "remaining_amount" => $this->remaining_amount,
            "created_at" => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
