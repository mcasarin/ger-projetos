<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
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
            User::create([
                'name' => 'Márcio',
                'email' => 'marcio@etwas.com.br',
                'password' => '123456A#',
                'status' => '2',
        ]);
        }
        
        try {
            // Se não encontrar o registro com e-mail, cadastra
            User::firstOrCreate(
                ['email' => 'ricardo@etwas.com.br'], // busca
                ['name' => 'Ricardo', 'email' => 'ricardo@etwas.com.br','password' => '123456A#'], // cadastro
            );
        }catch(Exception $e){
            // Tratar erro de duplicidade ou outro erro
            //Log::error('Erro ao criar usuário: ' . $e->getMessage());
        }
    }
}
