<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StatusUser;
use Exception;
use Illuminate\Support\Facades\Log;

class StatusUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try{
            $count = StatusUser::count();
            if($count > 0){
                return; // Já existem registros, não faz nada
            } else {
                $statuses = ['Novo', 'Ativo', 'Inativo', 'Pendente'];
                foreach($statuses as $status){
                    StatusUser::create([
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
