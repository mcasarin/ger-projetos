<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class AuthController extends Controller
{
    // Login
    public function index() {
        return view('auth.login');
    }
    // Processar login
    public function loginProcess(AuthRequest $request) {
        // Validar os dados do formulário
        try {
            // valida o usuário e senha
            $authenticated = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            if(!$authenticated) {
                // Logar falha de login
                Log::warning('Tentativa de login falhou para o email: ' . $request->email);
                // redireciona usuário enviando msg de erro
                return back()->withInput()->with(['error' => 'Usuário ou senha inválidos!']);
            }
            // Salvar log de login bem-sucedido
            Log::info('Usuário logado com sucesso.', ['user_id' => Auth::id()]);
            
            // Redirecionar para a página inicial após o login bem-sucedido
            return redirect()->route('dashboard.index');
        } catch (Exception $e) {
            // Logar o erro (opcional)
            Log::notice('Dados de login incorretos.', ['error' => $e->getMessage()]);

            // Tratar erros inesperados
            return redirect()->back()->withErrors(['login_error' => 'Usuário ou senha inválidos!!!.'])->withInput();
        }
    }

    // Logout
    public function logout() {
        // Salvar log de logout
        Log::info('Usuário deslogado.', ['user_id' => Auth::id()]);
        Auth::logout();
        return redirect()->route('home');

        // Redirecionar para a página inicial após o logout
        return redirect()->route('home')->with('success', 'Logout realizado com sucesso!');
    }   
}
