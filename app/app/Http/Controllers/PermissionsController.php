<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    // Listar os papéis
    public function index()
    {
        // Recuperar os registros do banco dados
        $permissions = Permission::orderBy('title', 'ASC')->paginate(10);

        // Salvar log
        Log::info('Listar as permissões.', ['action_user_id' => Auth::id()]);

        // Carregar a view 
        return view('permissions.index', ['permissions' => $permissions]);
    }

    // Visualizar os detalhes do papel
    public function show(Permission $permission)
    {
        // Salvar log
        Log::info('Visualizar a permissão.', ['permission_id' => $permission->id, 'action_user_id' => Auth::id()]);

        // Carregar a view 
        return view('permissions.show', ['permission' => $permission]);
    }

    // Carregar o formulário cadastrar novo papel
    public function create()
    {
        // Carregar a view 
        return view('permissions.create');
        // Salvar log
        Log::info('Acessando Criar uma permissão.', ['permission_id' => $permission->id, 'action_user_id' => Auth::id()]);
    }

    // Cadastrar no banco de dados o novo papel
    public function store(PermissionRequest $request)
    {
        // Capturar possíveis exceções durante a execução.
        try {
            // Cadastrar no banco de dados na tabela permissions
            $permission = Permission::create([
                'title' => $request->title,
                'name' => $request->name,
            ]);

            // Salvar log
            Log::info('Permissão cadastrada.', ['permission_id' => $permission->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('permissions.show', ['permission' => $permission->id])->with('success', 'Permissão cadastrada com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Permissão não cadastrada.', ['error' => $e->getMessage(), 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Permissão não cadastrada!');
        }
    }

    // Carregar o formulário editar papel
    public function edit(Permission $permission)
    {
        // Carregar a view 
        return view('permissions.edit', ['permission' => $permission]);
    }

    // Editar no banco de dados o papel
    public function update(PermissionRequest $request, Permission $permission)
    {
        // Capturar possíveis exceções durante a execução.
        try {
            // Editar as informações do registro no banco de dados
            $permission->update([
                'title' => $request->title,
                'name' => $request->name
            ]);

            // Salvar log
            Log::info('Permissão editada.', ['permission_id' => $permission->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('permissions.show', ['permission' => $permission->id])->with('success', 'Permissão editada com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Permissão não editada.', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Permissão não editada!');
        }
    }

    // Excluir o papel do banco de dados
    public function destroy(Permission $permission)
    {
        // Capturar possíveis exceções durante a execução.
        try {

            // Excluir o registro do banco de dados
            $permission->delete();

            // Salvar log
            Log::info('Permissão apagada.', ['permission_id' => $permission->id, 'action_user_id' => Auth::id()]);
            
            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('permission.index')->with('success', 'Permissão apagada com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Permissão não apagada.', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Permissão não apagada!');
        }
    }
}