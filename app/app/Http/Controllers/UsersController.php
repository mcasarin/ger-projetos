<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
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

    public function edit(User $user) {
        // Carregar a view com o formulário de edição
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user) {
        
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
}
