<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class WarehouseRequest extends FormRequest
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
        $warehouseId = $this->route('warehouse') ;
        return [
            'name' => ['required', 'string', 'max:255', 'unique:warehouses,name,' . $warehouseId],
            'description' => ['nullable', 'string'],
            'status' => [
                'required',
                Rule::in(\App\Enums\WarehouseStatusEnum::values())
            ],
        ];
    }
}
