<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

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
    public function store(Request $request) {
        // dd($request->all()); // Imprime todos os dados recebidos do formulário
        // Validar os dados recebidos do formulário
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);

        // Redirecionar para a lista de usuários com uma mensagem de sucesso
        return redirect()->route('users.index')->with('success', 'Usuário cadastrado com sucesso!');
    }

    // Detalhes do usuário
    public function show(User $user) {
        // Carregar a view com os detalhes do projeto
        return view('users.show', ['user' => $user]);
    }
}
