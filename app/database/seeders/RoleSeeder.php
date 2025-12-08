<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * (EN) Run the database seeds to create roles.
     * (PT-BR) Executa os seeders do banco de dados para criar papéis.
     */
    public function run(): void
    {
        // Super Admin
        Role::firstOrCreate(
            ['name' => 'Super Admin'],
            ['name' => 'Super Admin']
        );

        // Admin
        $admin = Role::firstOrCreate(
            ['name' => 'Admin'],
            ['name' => 'Admin']
        );
        // Cadastrar as permissões do papel Admin
        $admin->givePermissionTo([
            'index-projects',
            'show-projects',
            'create-projects',
            'edit-projects',
            'destroy-projects',
            'index-users',
            'show-users',
            'create-users',
            'edit-users',
            'edit-users-password',
            'index-status-projs',
            'create-status-projs',
            'index-tasks',
            'show-tasks',
            'create-tasks',
            'edit-tasks',
            'destroy-tasks',
            'index-type-moviments',
            'create-type-moviments',
            'index-moviments',
            'show-moviments',
            'create-moviments',
            'edit-moviments',
            'destroy-moviments',
            'index-roles',
            'show-roles',
            'create-roles',
            'edit-roles',
            'destroy-roles',
            'index-role-permission',
            'update-role-permission',
            'index-permissions',
            'show-permissions',
            'create-permissions',
            'edit-permissions',
            'destroy-permissions',
        ]);

        // User
        $user = Role::firstOrCreate(
            ['name' => 'User'],
            ['name' => 'User']
        );
        // Cadastrar as permissões do papel Usuario
        $user->givePermissionTo([
            'index-projects',
            'show-projects',
            'create-projects',
            'edit-projects',
            'index-users',
            'show-users',
            'index-status-projs',
            'index-tasks',
            'show-tasks',
            'create-tasks',
            'edit-tasks',
            'index-type-moviments',
            'index-moviments',
            'show-moviments',
            'create-moviments',
            'edit-moviments',
        ]);
    }
}
