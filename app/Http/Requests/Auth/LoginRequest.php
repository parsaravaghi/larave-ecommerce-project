<?php

namespace App\Http\Requests\Auth;

use App\Interfaces\Services\UserServiceInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{

    public function __construct(
        private UserServiceInterface $userService
    ){}

    public function authorize(): bool
    {
        return !$this->userService->is_authenticated();
    }

    public function rules(): array
    {
        return [
            "username" => "required|string|max:20" ,
            "password" => "required|string|min:8"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            "success" => false ,
            "errors" => $validator->errors() ,
            "data" => null
        ] , 409);

        throw new HttpResponseException($response);
    }

    protected function failedAuthorization()
    {
        return response()->json([
            "success" => false ,
            "errors" => ["Authorization" => "You are authorized"]
        ] , 409);
    }
}
