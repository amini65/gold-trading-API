<?php

namespace App\Http\Requests;


use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class UserOrderRequest extends FormRequest
{
    use ResponseTrait;


    public function rules(): array
    {
        return [
            "user_id" => ["required", "exists:users,id"]
        ];

    }


    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return  throw new HttpResponseException( $this->errorResponse($validator->errors() , 422));

    }
}
