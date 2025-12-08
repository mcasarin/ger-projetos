<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            // cria as permissões necessárias com array
            $permissions = [
                ['title' => 'Dashboard', 'name' => 'dashboard'],
                ['title' => 'Visualizar Perfil', 'name' => 'show-profile'],
                ['title' => 'Editar Perfil', 'name' => 'edit-profile'],
                ['title' => 'Editar Senha do Perfil', 'name' => 'edit-password-profile'],
                ['title' => 'Listar Projetos', 'name' => 'index-projects'],
                ['title' => 'Visualizar Projetos', 'name' => 'show-projects'],
                ['title' => 'Criar Projetos', 'name' => 'create-projects'],
                ['title' => 'Editar Projetos', 'name' => 'edit-projects'],
                ['title' => 'Deletar Projetos', 'name' => 'destroy-projects'],
                ['title' => 'Listar Usuários', 'name' => 'index-users'],
                ['title' => 'Visualizar Usuários', 'name' => 'show-users'],
                ['title' => 'Criar Usuários', 'name' => 'create-users'],
                ['title' => 'Editar Usuários', 'name' => 'edit-users'],
                ['title' => 'Editar Senha de Usuários', 'name' => 'edit-users-password'],
                ['title' => 'Listar Status de Projetos', 'name' => 'index-status-projs'],
                ['title' => 'Criar Status de Projetos', 'name' => 'create-status-projs'],
                ['title' => 'Listar Tarefas', 'name' => 'index-tasks'],
                ['title' => 'Visualizar Tarefas', 'name' => 'show-tasks'],
                ['title' => 'Criar Tarefas', 'name' => 'create-tasks'],
                ['title' => 'Editar Tarefas', 'name' => 'edit-tasks'],
                ['title' => 'Deletar Tarefas', 'name' => 'destroy-tasks'],
                ['title' => 'Listar Tipos de Movimentos', 'name' => 'index-type-moviments'],
                ['title' => 'Criar Tipos de Movimentos', 'name' => 'create-type-moviments'],
                ['title' => 'Listar Movimentos', 'name' => 'index-moviments'],
                ['title' => 'Visualizar Movimentos', 'name' => 'show-moviments'],
                ['title' => 'Criar Movimentos', 'name' => 'create-moviments'],
                ['title' => 'Editar Movimentos', 'name' => 'edit-moviments'],
                ['title' => 'Deletar Movimentos', 'name' => 'destroy-moviments'],
                ['title' => 'Listar Papéis', 'name' => 'index-roles'],
                ['title' => 'Visualizar Papéis', 'name' => 'show-roles'],
                ['title' => 'Criar Papéis', 'name' => 'create-roles'],
                ['title' => 'Editar Papéis', 'name' => 'edit-roles'],
                ['title' => 'Deletar Papéis', 'name' => 'destroy-roles'],
                ['title' => 'Listar Permissões de Papéis', 'name' => 'index-role-permission'],
                ['title' => 'Atualizar Permissões de Papéis', 'name' => 'update-role-permission'],
                ['title' => 'Listar Permissões', 'name' => 'index-permissions'],
                ['title' => 'Visualizar Permissões', 'name' => 'show-permissions'],
                ['title' => 'Criar Permissões', 'name' => 'create-permissions'],
                ['title' => 'Editar Permissões', 'name' => 'edit-permissions'],
                ['title' => 'Deletar Permissões', 'name' => 'destroy-permissions'],
            ];

        foreach ($permissions as $permission) {
            // Se não existir, cria a permissão com o title e name
            Permission::firstOrCreate(
                ['title' => $permission['title'], 'name' => $permission['name']],
                [
                    'title' => $permission['title'],
                    'name' => $permission['name'],
                    'guard_name' => 'web'
                ],
            );
        }
    } catch(Exception $e) {
            // Log de erro
            Log::error('Erro ao cadastrar permissões pelo seeder: ' . $e->getMessage());
        }
    }
}
