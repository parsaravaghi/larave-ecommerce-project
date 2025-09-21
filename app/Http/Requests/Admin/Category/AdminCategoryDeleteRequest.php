<?php

namespace App\Http\Requests\Admin\Category;

use App\Interfaces\Services\UserServiceInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminCategoryDeleteRequest extends FormRequest
{
    public function __construct(
        private UserServiceInterface $userService
    ) {}

    public function authorize(): bool
    {
        return $this->userService->isUserAdmin();
    }


    public function rules(): array
    {
        return [
            "id" => "numeric|digits_between:1,10|exists:categories|unique:categories,parent_id"
        ];
    }

    protected function prepareForValidation()
    {
        $this->replace(["id" => $this->route('id')]);
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

    protected function failedAuthorization()
    {
        abort(404);
    }
}
