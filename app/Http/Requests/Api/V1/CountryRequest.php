<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
            'code' => 'required|string|max:3|unique:countries,code,' . $this->country,
            'phone_code' => 'nullable|string|max:10',
            'currency_code' => 'nullable|string|max:3',
            'currency_symbol' => 'nullable|string|max:10',
            'is_active' => 'boolean',
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
            'name.required' => 'Country name is required.',
            'code.required' => 'Country code is required.',
            'code.unique' => 'This country code is already taken.',
        ];
    }
}
