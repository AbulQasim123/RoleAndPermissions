<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
            'edit_role' => 'required|string|unique:roles,name,' . $this->id,
        ];
    }
    public function messages(): array
    {
        return [
            'edit_role.required' => 'Role name is required',
            'edit_role.unique' => 'Role name already exists',
        ];
    }
}
