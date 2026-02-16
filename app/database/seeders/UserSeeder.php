<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker;
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
                'password' => 'N@pol3ao02',
                'status' => '2',
            ]);
            // Atribuindo papel de Super Admin e Admin
            $superAdmin->assignRole('Super Admin');
            $superAdmin->assignRole('Admin');
        }
        if(App::environment() != 'production'){ // Cria usuários na base de testes
            
            try {
                // Se não encontrar o registro com e-mail, cadastra
                $admin = User::firstOrCreate(
                    ['email' => 'ricardo@etwas.com.br'], // busca
                    ['name' => 'Ricardo', 'email' => 'ricardo@etwas.com.br','password' => 'nov453nh@','status' => '1'], // cadastro
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

                // Gerar nomes e emails aleatórios
                $faker = Faker::create();
                for ($i = 0; $i < 100; $i++) {
                    $user = User::create([
                        'name' => $faker->name,
                        'email' => $faker->unique()->safeEmail,
                        'password' => '123456A#',
                        'status' => '1',
                    ]);
                    $user->assignRole('User');
                }

            }catch(Exception $e){
                // Tratar erro de duplicidade ou outro erro
                Log::error('Erro ao criar usuário pela Seeder: ' . $e->getMessage());
            }
        }
    }
}
