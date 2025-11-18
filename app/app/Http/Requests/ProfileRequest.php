<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // padrão é false, alterado para true
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');
        return [
            'name' => 'required',
            // Aqui o ternário testa se é do próprio usuário (na edição), se for, ignora o email
            'email' => 'required|email|unique:users,email,'. ($user ? $user->id : null),
            // Aqui é feita a implementação para que a senha seja opcional na edição do usuário
            'password' => 'required_if:password,!=null|min:6',
        ];
    }
    public function messages(): array // tradução das mensagens de erro
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de email válido.',
            'email.unique' => 'O email informado já está em uso.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo :min caracteres.',
        ];
    }
}
