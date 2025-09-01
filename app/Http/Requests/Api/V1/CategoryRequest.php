<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $categoryId = $this->route('category');
        
        return [
            'category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'category_name')->ignore($categoryId),
            ],
            'category_description' => 'nullable|string|max:65535',
            'placeholder' => 'nullable|string|max:65535',
            'active' => 'boolean',
            'parent_id' => 'nullable|exists:categories,id',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'category_name.required' => 'Category name is required.',
            'category_name.unique' => 'This category name is already taken.',
            'parent_id.exists' => 'Parent category does not exist.',
        ];
    }
}
