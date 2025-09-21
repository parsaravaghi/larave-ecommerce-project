<?php

namespace App\Http\Requests\Admin\Product;

use App\Interfaces\Services\UserServiceInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AdminProductDeleteRequest extends FormRequest
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
            "id" => "numeric|digits_between:1,10"
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            "status" => false ,
            "errors" => $validator->errors()  ,
            "data" => null 
        ]);

        throw new HttpResponseException($response);
    }
}
