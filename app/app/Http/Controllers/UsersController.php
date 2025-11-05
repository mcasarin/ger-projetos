<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPasswordRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller
{
    public function index(User $user) {
        // Recupera os registros do banco de dados
        $users = User::orderBy('id', 'asc')->paginate(5);

        // Salvar log
        Log::info('Lista de usuários acessada.');

        //Carregar a view
        return view('users.index',['users' => $users]);
    }

    public function create() {
        //Carregar a view
        return view('users.create');
    }
    public function store(UserRequest $request) {
        // dd($request->all()); // Imprime todos os dados recebidos do formulário
        // Validar os dados recebidos do formulário
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'status' => '1', // Novo
                'password' => $request->password,
            ]);

            // Salva log
            Log::info('Novo usuário cadastrado.', ['user_id' => $user->id]);
        
            // Redirecionar para a lista de usuários com uma mensagem de sucesso
            return redirect()->route('users.show', ['user' => $user->id])->with('success', 'Usuário cadastrado com sucesso!');
        } catch (Exception $e) {
            //Salva log de erro
            Log::notice('Erro ao cadastrar novo usuário.', ['error' => $e->getMessage()]);
        }
    }

    // Detalhes do usuário
    public function show(User $user) {
        // Salva log
        Log::info('Detalhes do usuário acessados.', ['user_id' => $user->id]);

        // Carregar a view com os detalhes do projeto
        return view('users.show', ['user' => $user]);
    }

    public function edit(User $user) {
        // Carregar a view com o formulário de edição
        return view('users.edit', ['user' => $user]);
    }

    public function update(UserRequest $request, User $user) {
        
        // Validar os dados recebidos do formulário
        try{
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        // Salva log
        Log::info('Usuário editado.', ['user_id' => $user->id]);

        return redirect()->route('users.show', ['user' => $user->id])->with('success', 'Usuário editado com sucesso!');
        
        } catch (Exception $e) {
            // Salva log de erro
            Log::notice('Erro ao editar usuário.', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            // Redirecionar para a lista de projetos com uma mensagem de sucesso
            return back()->withInput()->with('error', 'Usuário não editado!!!');
        }
    }
    // Formulário para editar a senha do usuário
    public function editPassword(User $user) {
        // Carregar a view com o formulário de edição
        return view('users.edit_password', ['user' => $user]);
    }

    public function updatePassword(UserPasswordRequest $request, User $user) {
        // Validar formulário de atualização de senha
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ],
        [
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo :min caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
        ]);
        
        // Atualizar a senha do usuário
        try {
            $user->update([
                'password' => $request->password,
            ]);
            // Salva log
            Log::info('Senha do usuário alterada.', ['user_id' => $user->id]);

            return redirect()->route('users.show', ['user' => $user->id])->with('success', 'Senha alterada com sucesso!');
        } catch (Exception $e) {
            // Salva log de erro
            Log::notice('Erro ao alterar a senha do usuário.', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            
            // Redirecionar para a lista de projetos com uma mensagem de sucesso
            return back()->withInput()->with('error', 'Senha não editada!!!');
        }
    }
// EOC
}
