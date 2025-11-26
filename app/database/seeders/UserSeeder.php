<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Exception;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!User::where('email', 'marcio@etwas.com.br')->first()){
            // Se não existir o usuário, cria ele
            $superAdmin = User::create([
                'name' => 'Márcio',
                'email' => 'marcio@etwas.com.br',
                'password' => '123456A#',
                'status' => '2',
            ]);
            // Atribuindo papel de Super Admin e Admin
            $superAdmin->assignRole('Super Admin');
            $superAdmin->assignRole('Admin');
        }
        
        try {
            // Se não encontrar o registro com e-mail, cadastra
            $admin = User::firstOrCreate(
                ['email' => 'ricardo@etwas.com.br'], // busca
                ['name' => 'Ricardo', 'email' => 'ricardo@etwas.com.br','password' => '123456A#','status' => '1'], // cadastro
            );
            // Atribuindo papel de Admin
            $admin->assignRole('Admin');

        }catch(Exception $e){
            // Tratar erro de duplicidade ou outro erro
            Log::error('Erro ao criar usuário pela Seeder: ' . $e->getMessage());
        }

        try {
            // Se não encontrar o registro com e-mail, cadastra
            $user = User::firstOrCreate(
                ['email' => 'eduardo@etwas.com.br'], // busca
                ['name' => 'Eduardo', 'email' => 'eduardo@etwas.com.br','password' => '123456A#','status' => '1'], // cadastro
            );
            // Atribuindo papel de Admin
            $user->assignRole('User');

        }catch(Exception $e){
            // Tratar erro de duplicidade ou outro erro
            Log::error('Erro ao criar usuário pela Seeder: ' . $e->getMessage());
        }
    }
}
