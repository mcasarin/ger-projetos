<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfilePasswordRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProfilesController extends Controller
{
    public function show() {
        // Busca as informações do usuário logado
        $user = User::where('id', Auth::id())->first();

        // Salva log
        Log::info('Visualizando o perfil.', ['action_user_id' => Auth::id()]);

        // Carregar a view com os detalhes do perfil
        return view('profiles.show', ['user' => $user]);
    }

    public function edit() {
        // Busca as informações do usuário logado
        $user = User::where('id', Auth::id())->first();

        // Carregar a view com o formulário de edição
        return view('profiles.edit', ['user' => $user]);
    }

    public function update(ProfileRequest $request) {
        // Busca as informações do usuário logado
        $user = User::where('id', Auth::id())->first();
        
        // Validar os dados recebidos do formulário
        try{
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        // Salva log
        Log::info('Perfil editado.', ['perfil id:' => Auth::id()]);

        return redirect()->route('profile.show', ['user' => $user->id])->with('success', 'Perfil editado com sucesso!');
        
        } catch (Exception $e) {
            // Salva log de erro
            Log::notice('Erro ao editar perfil.', ['perfil' => $user->id, 'error' => $e->getMessage(), 'por user_id' => Auth::id()]);
            // Redirecionar para a lista de projetos com uma mensagem de sucesso
            return back()->withInput()->with('error', 'Perfil não editado!!!');
        }
    }
    // Formulário para editar a senha do usuário
    public function editPassword() {
        // Busca as informações do usuário logado
        $user = User::where('id', Auth::id())->first();

        // Carregar a view com o formulário de edição
        return view('profiles.edit_password', ['user' => $user]);
    }

    public function updatePassword(ProfilePasswordRequest $request) {
        // Busca as informações do usuário logado
        $user = User::where('id', Auth::id())->first();

        // Validar formulário de atualização de senha
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ],
        [
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo :min caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
        ]);
        
        // Atualizar a senha do perfil
        try {
            $user->update([
                'password' => $request->password,
            ]);
            // Salva log
            Log::info('Senha do perfil alterada.', ['perfil' => Auth::id()]);

            return redirect()->route('profile.show', ['user' => $user->id])->with('success', 'Senha alterada com sucesso!');
        } catch (Exception $e) {
            // Salva log de erro
            Log::notice('Erro ao alterar a senha do perfil.', ['perfil' => $user->id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);
            
            // Redirecionar para a lista de projetos com uma mensagem de sucesso
            return back()->withInput()->with('error', 'Senha não editada!!!');
        }
    }
}
