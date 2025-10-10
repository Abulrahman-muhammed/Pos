<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\SafeStatusEnum;
use App\Enums\SafeTypeEnum;
class safeUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'balance' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(SafeStatusEnum::values())],
            'type' => ['required', Rule::in(SafeTypeEnum::values())],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
