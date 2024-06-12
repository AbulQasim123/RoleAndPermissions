<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRouterRequest extends FormRequest
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
            'update_permissions_id' =>  'required',
            'update_routes' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'update_permissions_id.required' => 'Permission is required',
            'update_routes.required' => 'Route Name is required',
        ];
    }
}
