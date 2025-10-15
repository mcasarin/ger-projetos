<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class UsersController extends Controller
{
    public function index() {
        // Recupera os registros do banco de dados
        $users = User::orderBy('id', 'asc')->get();

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
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Redirecionar para a lista de usuários com uma mensagem de sucesso
        return redirect()->route('users.index')->with('success', 'Usuário cadastrado com sucesso!');
    }

    // Detalhes do usuário
    public function show(User $user) {
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

        return redirect()->route('users.show', ['user' => $user->id])->with('success', 'Usuário editado com sucesso!');
        
        } catch (Exception $e) {
            // Redirecionar para a lista de projetos com uma mensagem de sucesso
            return back()->withInput()->with('error', 'Usuário não editado!!!');
        }
    }
    // Formulário para editar a senha do usuário
    public function editPassword(User $user) {
        // Carregar a view com o formulário de edição
        return view('users.edit_password', ['user' => $user]);
    }

    public function updatePassword(Request $request, User $user) {
        
        // Validar os dados recebidos do formulário
        $request->validate([
                'password' => 'required|min:6', //campo e regras
            ],
            [ // mensagens de erro personalizadas
                'password.required' => 'O campo senha é obrigatório.',
                'password.min' => 'A senha deve ter no mínimo :min caracteres.',
            ]);

        try{
        $user->update([
            'password' => $request->password,
        ]);

        return redirect()->route('users.show', ['user' => $user->id])->with('success', 'Senha alterada com sucesso!');
        
        } catch (Exception $e) {
            // Redirecionar para a lista de projetos com uma mensagem de sucesso
            return back()->withInput()->with('error', 'Senha não editada!!!');
        }
    }


}
