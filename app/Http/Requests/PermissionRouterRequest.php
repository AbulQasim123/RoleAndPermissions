<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRouterRequest extends FormRequest
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
            'permissions_id' =>  'required',
            'routes' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'permissions_id.required' => 'Permission is required',
            'routes.required' => 'Route Name is required',
        ];
    }
}
