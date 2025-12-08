<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
        $permission = $this->route('permission');
        return [
            'title' => 'required|unique:permissions,title,' . ($permission ? $permission->id : null),
            'name' => 'required|unique:permissions,name,' . ($permission ? $permission->id : null),
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O campo título é obrigatório.',
            'title.unique' => 'Já existe uma permissão com este título.',
            'name.required' => 'O campo nome é obrigatório.',
            'name.unique' => 'Já existe uma permissão com este nome.',
        ];
    }
}
