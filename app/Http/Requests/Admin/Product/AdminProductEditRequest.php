<?php

namespace App\Http\Requests\Admin\Product;

use App\Interfaces\Services\UserServiceInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminProductEditRequest extends FormRequest
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
            "id" => "required|numeric|max:10000000" ,
            "title" => "string|max:50|unique:products" , 
            "description" => "string|max:300" , 
            "image_url" => "url",
            "price" => "numeric|max:1000000000" ,
            "products_count" => "numeric|max:1000000" ,
            "sales_count" => "numeric|max:10000000" ,
            "category_id" => "numeric|nullable|max:10000000" ,
        ];
    }

    protected function failedAuthorization()
    {
        abort(404);
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            "status" => false ,
            "errors" => $validator->errors() ,
            "data" => null
        ] , 401);

        throw new HttpResponseException($response);
    }

    protected function prepareForValidation()
    {
        $this->merge(["id" => $this->route('id')]);
    }
}
