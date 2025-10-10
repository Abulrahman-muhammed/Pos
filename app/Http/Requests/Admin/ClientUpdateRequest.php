<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ClientStatusEnum;
class ClientUpdateRequest extends FormRequest
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
            'email' => ['nullable', 'email', 'max:255', Rule::unique('clients')->ignore($this->client)],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('clients')->ignore($this->client)],
            'address' => ['nullable', 'string', 'max:500'],
            'balance' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(ClientStatusEnum::values())],
        ];
    }
}
