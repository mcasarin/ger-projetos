<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\StatusProj;
use Illuminate\Database\Seeder;
use Exception;

class StatusProjSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try{
            // Verifica se a tabela já possui registros
            $count = StatusProj::table('status_proj')->count();
            if($count > 0){
                return; // Já existem registros, não faz nada
            } else {
                $statuses = ['Planejado', 'Em Andamento', 'Concluído', 'Cancelado'];
                foreach($statuses as $status){
                    StatusProj::table('status_proj')->insert([
                        'status' => $status,
                    ]);
                }
            }
            
        }catch(Exception $e){
            // Tratar erro de duplicidade ou outro erro
            // Log::error('Erro ao criar status: ' . $e->getMessage());
        }
    }
}
