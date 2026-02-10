<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index(Role $role) {
        if($role->name == 'Super Admin'){

        // Salvar log
        Log::info('A permissão do super admin não pode ser acessada.', ['role_id' => $role->id, 'action_user_id' => Auth::id()]);
        // redireciona com mensagem de erro
        return redirect()->route('roles.index')->with('error', 'A permissão do Super Admin não pode ser acessada.');
        
        }
        // Recupera as permissões do papel
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_id', $role->id)
            ->pluck('permission_id')
            ->all();
        // Recupera todas as permissões disponíveis
        $permissions = Permission::orderBy('name', 'ASC')->get();

        // Salvar log
        Log::info('Listar as permissões do papel.', ['role_id' => $role->id, 'action_user_id' => Auth::id()]);

        //Carregar a view
        return view('role_permissions.index', [
            'role' => $role,
            'rolePermissions' => $rolePermissions,
            'permissions' => $permissions,
        ]);
    }

    public function update(Role $role, Permission $permission) {
        try {
            // Define ação, bloquear ou liberar com base na permissão atual
            $action = $role->permissions->contains($permission) ? 'bloquear' : 'liberar';
            // Liberar ou bloquear a permissão para o papel
            $role->{$action === 'bloquear' ? 'revokePermissionTo' : 'givePermissionTo'}($permission);

            // Salvar log
            Log::info(ucfirst($action).' a permissão do papel.', [
                'role_id' => $role->id, 
                'permission_id' => $permission->id, 
                'action_user_id' => Auth::id()
            ]);

            // Redirecionar de volta com mensagem de sucesso
            return redirect()->route('role-permission.index', $role->id)->with('success', 'Permissão ' . ($action === 'bloquear' ? 'bloqueada' : 'liberada') . ' com sucesso.');
        } catch (Exception $e) {

            // Salvar log de erro
            Log::error('Erro ao atualizar a permissão do papel.', ['role_id' => $role->id, 'permission_id' => $permission->id, 'action_user_id' => Auth::id(), 'error' => $e->getMessage()]);

            return back()->withInput()->with('error', 'Ocorreu um erro ao atualizar a permissão.');
        }
        
    }
}
