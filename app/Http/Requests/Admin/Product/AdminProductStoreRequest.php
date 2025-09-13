<?php

namespace App\Http\Requests\Admin\Product;

use App\Interfaces\Services\UserServiceInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminProductStoreRequest extends FormRequest
{
    public function __construct(
        private UserServiceInterface $userService
    ){}

    public function authorize(): bool
    {
        return $this->userService->isUserAdmin();
    }

    public function rules(): array
    {
        return [
            "title" => "required|string|max:50|unique:products" , 
            "description" => "required|string|max:300" , 
            "image_url" => "required|url",
            "price" => "required|numeric|max:1000000000" ,
            "products_count" => "required|numeric|max:1000000" ,
            "sales_count" => "required|numeric|max:10000000" ,
            "category_id" => "nullable|numeric|max:10000000|exist:categories,id" ,
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            "success" =>  false ,
            "errors" => $validator->errors() ,
            "data" => null
        ] , 401);

        throw new HttpResponseException($response);
    }

    protected function failedAuthorization()
    {
        abort(404);
    }
}
