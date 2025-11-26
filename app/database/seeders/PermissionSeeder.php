<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
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
        ];

        foreach ($permissions as $permission) {
            // Se não existir, cria a permissão
            Permission::firstOrCreate(
                ['name' => $permission],
                ['name' => $permission,
                'guard_name' => 'web']
            );
        }
    }
}
