<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:tags,name,' . $this->tag,
            'slug' => 'required|string|max:255|unique:tags,slug,' . $this->tag,
            'description' => 'nullable|string|max:65535',
            'color' => 'nullable|string|max:7',
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
            'name.required' => 'Tag name is required.',
            'name.unique' => 'This tag name is already taken.',
            'slug.required' => 'Slug is required.',
            'slug.unique' => 'This slug is already taken.',
        ];
    }
}
