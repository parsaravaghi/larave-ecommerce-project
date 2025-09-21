<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategorySearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "nullable|string" ,
            "limit" => "required|numeric|max:15" ,
            "part" => "required|numeric|digits_between:1,10"
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

    protected function prepareForValidation()
    {
        $this->replace($this->query());
    }
}
