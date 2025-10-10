<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\ItemStatusEnum;
use Illuminate\Validation\Rule;
class ItemUpdateRequest extends FormRequest
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
        $itemId = $this->route('item');
        return [
            'name'              => ['required', 'string', 'max:255'],
            'item_code'         => ['nullable', 'string', 'max:100', "unique:items,item_code,{$itemId}"],
            'description'       => ['nullable', 'string'],
            'price'             => ['required', 'numeric', 'min:0'],
            'quantity'          => ['required', 'numeric', 'min:0'],
            'minimum_stock'     => ['required', 'numeric', 'min:0'],
            'category_id'       => ['required', 'exists:categories,id'],
            'unit_id'           => ['required', 'exists:units,id'],
            'is_shown_in_store' => ['nullable', 'boolean'],
            'main_image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'gallery'   => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'status'            => ['required', Rule::in(ItemStatusEnum::values())],
            'delete_gallery'    => ['nullable', 'array'],
            'delete_gallery.*'  => ['integer', 'exists:files,id'],
        ];
    }
}
