<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\UserStatusEnum;
use Illuminate\Validation\Rule;
class UserUpdateRequest extends FormRequest
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
        $userId = $this->route('user');
        return [
            'username' => 'required|string|max:255|unique:users,username,'.$userId,
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,'.$userId,
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|' . Rule::in(UserStatusEnum::values()),
        ];
    }
}
