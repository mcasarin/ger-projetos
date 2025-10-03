<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Exception;
use App\Models\StatusTask;

class StatusTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try{
            $count = StatusTask::count();
            if($count > 0){
                return; // Já existem registros, não faz nada
            } else {
                $statuses = ['Não iniciada', 'Em Andamento', 'Concluída', 'Com impedimento', 'Atrasada'];
                foreach($statuses as $status){
                    StatusTask::create([
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
