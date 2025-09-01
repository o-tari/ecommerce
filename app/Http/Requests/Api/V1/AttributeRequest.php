<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class AttributeRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string|max:65535',
            'is_required' => 'boolean',
            'is_unique' => 'boolean',
            'is_filterable' => 'boolean',
            'is_searchable' => 'boolean',
            'is_comparable' => 'boolean',
            'is_visible_on_frontend' => 'boolean',
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
            'name.required' => 'Attribute name is required.',
            'type.required' => 'Attribute type is required.',
        ];
    }
}
