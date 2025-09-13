<?php

namespace App\Http\Requests\Admin\Product;

use App\Interfaces\Services\UserServiceInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminProductUpdateRequest extends FormRequest
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
            "id" => "required|numeric|digits_between:1,10" ,
            "title" => "string|max:50|unique:products" , 
            "description" => "string|max:300" , 
            "image_url" => "url",
            "price" => "numeric|digits_between:1,10" ,
            "products_count" => "numeric|digits_between:1,10" ,
            "sales_count" => "numeric|digits_between:1,10" ,
            "category_id" => "numeric|nullable|digits_between:1,10" ,
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
        $this->replace(["id" => $this->route('id')]);
    }
}
