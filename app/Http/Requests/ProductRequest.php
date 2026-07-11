<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['required', 'exists:brands,id'],

    'name' => [
        'required',
        'max:255',
        Rule::unique('products', 'name')->ignore(
            $product instanceof \App\Models\Product ? $product->id : $product
        ),
    ],

            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'lte:price'],
            'stock' => ['required', 'integer', 'min:0'],

            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'description' => 'nullable|string',

            'status' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
        ];
    }
}
