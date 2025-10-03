<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Exception;
use App\Models\TypeMovim;

class TypeMovimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try{
            $count = TypeMovim::count();
            if($count > 0){
                return; // Já existem registros, não faz nada
            } else {
                $statuses = ['Entrada', 'Saída', 'Transferência'];
                foreach($statuses as $status){
                    TypeMovim::create([
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
