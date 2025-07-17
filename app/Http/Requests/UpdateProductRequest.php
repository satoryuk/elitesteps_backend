<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_name' => 'sometimes|string|max:255|unique:products,product_name,',
            'description' => 'nullable|string|max:1000',
            'price' => 'sometimes|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'stock' => 'sometimes|integer|min:0',
            'brand_id' => 'nullable|exists:brands,brand_id',
            'type_id' => 'nullable|exists:types,type_id',
            'image' => 'nullable|string|max:2048',
            'status' => 'sometimes|integer', // 1 is active, 0 is inactive
        ];
    }
}
