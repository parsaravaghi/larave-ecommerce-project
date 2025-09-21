<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "id" => "numeric|max:10000000"
        ];
    }

    public function prepareForValidation()
    {
        // Replace user route with user data body
        $this->replace([
            'id' => $this->route('id')
        ]);
    }
}