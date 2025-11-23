<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\DiscountTypeEnum as DiscountType;
class SaleRequest extends FormRequest
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
            'client_id' => ['required', 'exists:clients,id'],
            'sale_date' => ['required', 'date'],
            'invoice_number' => ['required', 'string', 'max:255', 'unique:sales,invoice_number' ],
            'safe_id' => ['required', 'exists:safes,id'],
            'discount_type' => ['nullable', 'in:' . implode(',', DiscountType::values())],
            'discount_value' => ['nullable', 'numeric', 'min:0'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'exists:items,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.note' => ['nullable', 'string', 'max:255'],
            'payment_type' => ['required', 'in:' . implode(',', \App\Enums\PaymentTypeEnum::values())],
            'payment_amount' => ['required_if:payment_type,'. \App\Enums\PaymentTypeEnum::Debit->value, 'nullable', 'numeric', 'min:0'],
            'warehouse_id' => ['required', 'exists:warehouses,id'],
        ];
    }
}
