<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Exception;
use Mockery\Generator\StringManipulation\Pass\Pass;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot_password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Validação do e-mail
        $request->validate(['email' => 'required|email'],[
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
        ]);

        // verificar se o e-mail existe no banco de dados
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            // Salva log de erro
            Log::notice('Tentativa de recuperação de senha com e-mail não cadastrado', ['email' => $request->email]);
            
            // Redirecionar para a lista de projetos com uma mensagem de sucesso
            return back()->withInput()->with('error', 'E-mail não encontrado!!!');
        }
        try{
            // salva o token de reset de senha no banco de dados
            $status = Password::sendResetLink(
                $request->only('email')
            );
            // Salva log
            Log::info('Link de reset de senha enviado.', ['status' => $status, 'email' => $request->email]);
            // Redireciona
            return redirect()->route('login')->with('success', 'Enviado e-mail com instruções para o reset de senha');
            
        } catch (Exception $e) {
            // Salva log de erro
            Log::notice('Erro ao enviar link de reset de senha.', ['email' => $request->email]);
            
            // Redirecionar para a lista de projetos com uma mensagem de sucesso
            return back()->withInput()->with('error', 'Erro ao enviar o e-mail de reset de senha!!!');
        }

        return back()->with('status', 'Link de reset de senha enviado para o seu e-mail!');
    }

    public function showResetForm(Request $request) 
    {   
        try{
            // Recuperar os dados do token e do e-mail da requisição
            $user = User::where('email', $request->email)->first();
            // Verificar se o usuário existe
            if (!$user || !Password::tokenExists($user, $request->token)) {
                // Salva log de erro
                Log::notice('Tentativa de acesso ao formulário de reset de senha com token inválido.', ['email' => $request->email ? $request->email : 'N/A']);
                // Redirecionar para a página de login com uma mensagem de erro
                return redirect()->route('login')->with('error', 'Token inválido ou expirado!!!');
            }

            // Salva log
            Log::info('Acesso ao formulário de reset de senha.', ['email' => $request->email]);
            // Carrega a View de reset de senha
            return view('auth.reset_password', ['token' => $request->token, 'email' => $request->email]);

        } catch (Exception $e) {
            // Salva log de erro
            Log::notice('Erro ao acessar o formulário de reset de senha. Token inválido ou expirado', ['email' => $request->email]);
            // Redirecionar para a página de login com uma mensagem de erro
            return redirect()->route('login')->with('error', 'Token inválido ou expirado');
        }
        
    }

    public function reset(Request $request)
    {
        //dd($request);
        // Validação dos dados
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6|confirmed',
        ],[
            'token.required' => 'O token de reset de senha é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo :min caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
        ]);

        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password) {
                    // forceFill - forçar o acesso a atributos protegidos
                    $user->forceFill([
                        'password' => $password
                    ]);
                    // Salva a nova senha
                    $user->save();
                }
            );
            // Salva log
            Log::info('Senha atualizada!', ['status' => $status, 'email' => $request->email]);
            return $status === Password::PASSWORD_RESET ? redirect()->route('login')->with('success', 'Senha atualizada com sucesso!') : redirect()->route('login')->with('error', 'Senha não atualizada!!!');
        } catch (Exception $e) {
            
            // Salva log de erro
            Log::notice('Erro ao resetar a senha.', ['email' => $request->email]);
            return back()->withInput()->with('error', 'Erro ao resetar a senha!!!');
        }
    }
}
