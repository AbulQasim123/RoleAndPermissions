<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'username' => 'required|string|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3|max:8',
            'role' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'username.required' => 'Username is required',
            'username.unique' => 'Username is Already taken',
            'email.required' => 'Email is required',
            'email.unique' => 'Email is Already taken',
            'password.required' => 'Password is required',
            'password.min' => 'Password mininum 3 chars',
            'password.max' => 'Password maximum 8 chars',
            'role.required' => 'Please Select Role',
        ];
    }
}
