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
            "price" => "numeric|max:digits:10" ,
            "category" => "nullable|numeric|digits:7" ,
            "min_price" => "numeric" ,
            "max_price" => "numeric" ,
            "order" => "string" ,
            "part" => "required|numeric|digits:6" ,
            "limit" => "required|numeric|max:50"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            "success" => false ,
            "errors" => $validator->errors() ,
            "data" => null
        ] , 406);

        throw new HttpResponseException($response);
    }
    public function prepareForValidation()
    {
        // replace query string data to main request
        $this->replace($this->query());
    }
}
