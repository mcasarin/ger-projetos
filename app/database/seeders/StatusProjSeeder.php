<?php

namespace Database\Seeders;

use App\Models\StatusProj;
use Illuminate\Database\Seeder;
use Exception;
use Illuminate\Support\Facades\Log;

class StatusProjSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try{
            $count = StatusProj::count();
            if($count > 0){
                return; // Já existem registros, não faz nada
            } else {
                $statuses = ['Novo', 'Planejado', 'Em Andamento', 'Concluído', 'Cancelado'];
                foreach($statuses as $status){
                    StatusProj::create([
                        'status' => $status,
                    ]);
                }
            }
            }catch(Exception $e){
            // Tratar erro de duplicidade ou outro erro
            Log::error('Erro ao criar status: ' . $e->getMessage());
        }
    }
}
