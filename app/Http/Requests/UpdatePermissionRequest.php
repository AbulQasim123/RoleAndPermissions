<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
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
            'edit_permission' => 'required|string|unique:permissions,name,' . $this->id,
        ];
    }
    public function messages(): array
    {
        return [
            'edit_permission.required' => 'Permission name is required',
            'edit_permission.unique' => 'Permission name already exists',
        ];
    }
}
