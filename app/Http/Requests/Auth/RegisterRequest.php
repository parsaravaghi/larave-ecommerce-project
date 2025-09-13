<?php

namespace App\Http\Requests\Auth;

use App\Interfaces\Services\UserServiceInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            "username" => "required|string|max:20|unique:users" ,
            "password" => "required|string|min:8" ,
            "email" => "required|email|unique:users" ,
            "role" => "required|numeric|max:3"
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $reponse = response()->json([
            "success" => false ,
            "errors" => $validator->errors() ,
            "data" => null
        ]);

        throw new HttpResponseException($reponse);
    }

    protected function failedAuthorization()
    {
        $response = response()->json([
            "success" => false ,
            "errors" => ["Authorization" => "You are not Authorized"]
        ]);

        throw new HttpResponseException($response);
    }
}
