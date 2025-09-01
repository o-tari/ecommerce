<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        $rules = [
            'order_number' => 'string|max:255|unique:orders,order_number,' . $this->order,
            'customer_id' => 'exists:customers,id',
            'order_status_id' => 'exists:order_statuses,id',
            'subtotal' => 'numeric|min:0',
            'total_amount' => 'numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'shipping_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:65535',
            'shipping_address_id' => 'nullable|exists:customer_addresses,id',
            'billing_address_id' => 'nullable|exists:customer_addresses,id',
            'payment_method' => 'nullable|string|max:255',
            'payment_status' => 'nullable|string|max:255',
            'shipping_method' => 'nullable|string|max:255',
            'tracking_number' => 'nullable|string|max:255',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];

        // Make certain fields required only on creation
        if ($this->isMethod('POST')) {
            $rules['order_number'] = 'required|' . $rules['order_number'];
            $rules['customer_id'] = 'required|' . $rules['customer_id'];
            $rules['order_status_id'] = 'required|' . $rules['order_status_id'];
            $rules['subtotal'] = 'required|' . $rules['subtotal'];
            $rules['total_amount'] = 'required|' . $rules['total_amount'];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'order_number.required' => 'Order number is required.',
            'order_number.unique' => 'This order number is already taken.',
            'customer_id.required' => 'Customer is required.',
            'customer_id.exists' => 'Customer does not exist.',
            'order_status_id.required' => 'Order status is required.',
            'order_status_id.exists' => 'Order status does not exist.',
            'subtotal.required' => 'Subtotal is required.',
            'subtotal.numeric' => 'Subtotal must be a number.',
            'subtotal.min' => 'Subtotal must be at least 0.',
            'total_amount.required' => 'Total amount is required.',
            'total_amount.numeric' => 'Total amount must be a number.',
            'total_amount.min' => 'Total amount must be at least 0.',
        ];
    }
}
