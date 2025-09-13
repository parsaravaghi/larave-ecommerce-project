<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "title" => "max:50" , 
            "description" => "string|max:300" , 
            "price" => "numeric|max:1000000000" ,
            "category" => "nullable|numeric|max:10000000" ,
            "min_price" => "numeric" ,
            "max_price" => "numeric" ,
            "order" => "string" ,
            "part" => "required|numeric|max:100000" ,
            "limit" => "required|numeric|max:50"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            "status" => false ,
            "errors" => $validator->errors() ,
            "data" => null
        ]);

        throw new HttpResponseException($response);
    }
    public function prepareForValidation()
    {
        // replace query string data to main request
        $this->replace($this->query());
    }
}
