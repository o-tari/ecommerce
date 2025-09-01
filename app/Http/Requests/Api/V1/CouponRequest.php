<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'code' => 'required|string|max:255|unique:coupons,code,' . $this->coupon,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:65535',
            'discount_type' => 'required|string|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:0',
            'used_count' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
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
            'code.required' => 'Coupon code is required.',
            'code.unique' => 'This coupon code is already taken.',
            'name.required' => 'Coupon name is required.',
            'discount_type.required' => 'Discount type is required.',
            'discount_type.in' => 'Discount type must be either percentage or fixed.',
            'discount_value.required' => 'Discount value is required.',
            'discount_value.numeric' => 'Discount value must be a number.',
            'discount_value.min' => 'Discount value must be at least 0.',
            'expires_at.after' => 'Expiration date must be after start date.',
        ];
    }
}
