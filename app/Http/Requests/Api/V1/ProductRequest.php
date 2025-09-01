<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Will be handled by policies
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'product_name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'sale_price' => 'required|numeric|min:0',
            'compare_price' => 'required|numeric|min:0',
            'buying_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'short_description' => 'required|string|max:65535',
            'product_description' => 'required|string|max:65535',
            'published' => 'required|boolean',
            'disable_out_of_stock' => 'required|boolean',
            'note' => 'nullable|string|max:65535',
            'product_type' => 'nullable|string|in:simple,variable',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'suppliers' => 'nullable|array',
            'suppliers.*' => 'exists:suppliers,id',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];

        // Add shipping info rules if present
        if ($this->has('weight')) {
            $rules['weight'] = 'nullable|numeric|min:0';
            $rules['weight_unit'] = 'nullable|string|in:kg,lb';
        }

        if ($this->has('volume')) {
            $rules['volume'] = 'nullable|numeric|min:0';
            $rules['volume_unit'] = 'nullable|string|in:m3,ft3,cm3,in3';
        }

        if ($this->has('dimension_width')) {
            $rules['dimension_width'] = 'nullable|numeric|min:0';
            $rules['dimension_height'] = 'nullable|numeric|min:0';
            $rules['dimension_depth'] = 'nullable|numeric|min:0';
            $rules['dimension_unit'] = 'nullable|string|in:m,ft,cm,in';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'product_name.required' => 'Product name is required.',
            'slug.required' => 'Slug is required.',
            'slug.unique' => 'This slug is already taken.',
            'sale_price.required' => 'Sale price is required.',
            'sale_price.numeric' => 'Sale price must be a number.',
            'sale_price.min' => 'Sale price must be at least 0.',
            'compare_price.required' => 'Compare price is required.',
            'compare_price.numeric' => 'Compare price must be a number.',
            'compare_price.min' => 'Compare price must be at least 0.',
            'quantity.required' => 'Quantity is required.',
            'quantity.integer' => 'Quantity must be a whole number.',
            'quantity.min' => 'Quantity must be at least 0.',
            'short_description.required' => 'Short description is required.',
            'product_description.required' => 'Product description is required.',
            'published.required' => 'Published status is required.',
            'disable_out_of_stock.required' => 'Out of stock status is required.',
        ];
    }
}
