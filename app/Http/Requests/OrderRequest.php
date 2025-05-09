<?php

namespace App\Http\Requests;

use App\Enums\CurrencyTypeEnum;
use App\Enums\OrderTypeEnum;
use App\Rules\CheckWalletAmount;
use App\Rules\CheckWalletPrice;
use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;


class OrderRequest extends FormRequest
{
    use ResponseTrait;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "user_id" => ["required", "exists:users,id"],
            "order_type" => ["required", new Enum(OrderTypeEnum::class)],
            "amount" => ['required', 'numeric',new CheckWalletAmount($this)],
            "price" => ['required', 'numeric',new CheckWalletPrice($this)],
        ];

    }


        protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return  throw new HttpResponseException( $this->errorResponse($validator->errors() , 422));
//        parent::failedValidation($validator); // TODO: Change the autogenerated stub

    }
}
