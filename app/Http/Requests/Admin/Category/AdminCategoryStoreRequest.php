<?php

namespace App\Http\Requests\Admin\Category;

use App\Interfaces\Services\UserServiceInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminCategoryStoreRequest extends FormRequest
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
            "name" => "required|string|max:20|unique:categories" ,
            "description" => "required|string|max:100" ,
            "image_url" => "required|url" ,
            "parent_id" => "nullable|numeric|digits_between:1,6|exists:categories,id"
        ];
    }

    protected function failedAuthorization()
    {
        abort(404);
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
}
