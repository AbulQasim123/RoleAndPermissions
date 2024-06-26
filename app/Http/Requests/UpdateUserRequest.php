<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'user_id' => 'required',
            'u_username' => 'required|string',
            'u_email' => [
                'required',
                'email',
                'unique:users,email,' . request()->user_id,
                // Rule::unique('users')->ignore($this->user->id),
            ],
            'u_role' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'u_username.required' => 'Username is required',
            'u_email.required' => 'Email is required',
            'u_password.required' => 'Password is required',
            'u_email.unique' => 'Email is taken by another user',
            'u_role.required' => 'Please Select Role',
        ];
    }
}
