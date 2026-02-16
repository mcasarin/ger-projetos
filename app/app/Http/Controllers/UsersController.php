<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request) {
        // Recupera os registros do banco de dados
        // $users = User::orderBy('id', 'asc')->paginate(10);
        $users = User::when(
            $request->filled('name'),
            fn($query) => $query->whereLike('name', '%' . $request->name . '%')
        )
            ->when(
            $request->filled('email'),
            fn($query) => $query->whereLike('email', '%' . $request->email . '%')
        )
        ->when(
            $request->filled('start_date_registration'),
            fn($query) => $query->where('created_at', '>=', Carbon::parse($request->start_date_registration))
        )
        ->when(
            $request->filled('end_date_registration'),
            fn($query) => $query->where('created_at', '<=', Carbon::parse($request->end_date_registration))
        )
        ->orderBy('id', 'desc')
        ->paginate(10)
        ->withQueryString();

        // Salvar log
        Log::info('Lista de usuários acessada.');

        //Carregar a view
        return view('users.index',[
            'menu' => 'users',
            'name' => $request->name,
            'email' => $request->email,
            'start_date_registration' => $request->start_date_registration,
            'end_date_registration' => $request->end_date_registration,
            'users' => $users
            ]);
    }

    public function create() {
        // recupera e atribui papeis
        $roles = Role::pluck('name')->all();

        //Carregar a view
        return view('users.create', ['menu' => 'users', 'roles' => $roles]);
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
            // Atribuir papeis ao usuário
            if ($request->filled('roles')) {
                $validRoles = Role::whereIn('name', $request->roles)->pluck('name')->toArray();
                // atribuir papeis validos
                $user->syncRoles($validRoles);
            }

            // Salva log
            Log::info('Novo usuário cadastrado.', ['usuario cadastrado' => $user->id, 'por user_id' => Auth::id()]);
        
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
        Log::info('Visualizar o usuário.', ['user_id' => $user->id, 'action_user_id' => Auth::id()]);

        // Carregar a view com os detalhes do usuário
        return view('users.show', ['menu' => 'users', 'user' => $user]);
    }

    public function edit(User $user) {
        // Recupera os papéis
        $roles = Role::pluck('name')->all();
        // Recupera papeis do usuário
        $userRole = $user->roles->pluck('name')->toArray();
        // Carregar a view com o formulário de edição
        return view('users.edit', [
            'menu' => 'users',
            'user' => $user, 
            'roles' => $roles, 
            'userRole' => $userRole
        ]);
    }

    public function update(UserRequest $request, User $user) {
        
        // Validar os dados recebidos do formulário
        try{
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Se houver papeis selecionados, sincroniza os papeis do usuário
        if ($request->filled('roles')) {
            // Atribuir papeis ao usuário
            if ($request->filled('roles')) {
                $validRoles = Role::whereIn('name', $request->roles)->pluck('name')->toArray();
                // atribuir papeis validos
                $user->syncRoles($validRoles);
            }
        } else {
            // Se nenhum papel for selecionado, remove todos os papeis do usuário
            $user->syncRoles([]);
        }
        // Salva log
        Log::info('Usuário editado.', ['usuario editado' => $user->id, 'por user_id' => Auth::id()]);

        return redirect()->route('users.show', ['user' => $user->id])->with('success', 'Usuário editado com sucesso!');
        
        } catch (Exception $e) {
            // Salva log de erro
            Log::notice('Erro ao editar usuário.', ['usuario' => $user->id, 'error' => $e->getMessage(), 'por user_id' => Auth::id()]);
            // Redirecionar para a lista de projetos com uma mensagem de sucesso
            return back()->withInput()->with('error', 'Usuário não editado!!!');
        }
    }
    // Formulário para editar a senha do usuário
    public function editPassword(User $user) {
        // Carregar a view com o formulário de edição
        return view('users.edit_password', ['menu' => 'users', 'user' => $user]);
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
            Log::info('Senha do usuário alterada.', ['usuario' => $user->id, 'por user_id' => Auth::id()]);

            return redirect()->route('users.show', ['user' => $user->id])->with('success', 'Senha alterada com sucesso!');
        } catch (Exception $e) {
            // Salva log de erro
            Log::notice('Erro ao alterar a senha do usuário.', ['usuario' => $user->id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);
            
            // Redirecionar para a lista de projetos com uma mensagem de sucesso
            return back()->withInput()->with('error', 'Senha não editada!!!');
        }
    }

    public function destroy(User $user) {
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
            // salva log
            Log::info('Usuário excluído.', ['user_id' => $user->id, 'user_id' => Auth::id()]);
        } catch (Exception $e) {
            // salva log de erro
            Log::notice('Erro ao excluir usuário.', ['user_id' => $user->id, 'user_id' => Auth::id(), 'error' => $e->getMessage()]);
            return redirect()->route('users.index')->with('error', 'Erro ao excluir o usuário.');
        }
    }
// EOC
}
