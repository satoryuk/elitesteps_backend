<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'product_name' => 'required|string|max:255|unique:products,product_name',
            'description' => 'sometimes|string|max:1000',
            'price' => 'required|numeric|min:0',
            'discount' => 'sometimes|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'brand_id' => 'sometimes|exists:brands,brand_id',
            'type_id' => 'sometimes|exists:types,type_id',
            'image' => 'sometimes|string|max:2048',
            'status' => 'sometimes|integer', // 1 is active, 0 is inactive
        ];
    }
}
