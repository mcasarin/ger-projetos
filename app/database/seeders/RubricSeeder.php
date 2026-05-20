<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Exception;
use App\Models\Rubric;
use Illuminate\Support\Facades\Log;

class RubricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try{
            $count = Rubric::count();
            if($count > 0){
                return; // Já existem registros, não faz nada
            } else {
                $rubrics = ['Ajuda de custo', 'Benefício complementar', 'Bolsa', 'Diárias', 'Encargos e impostos', 'Material de consumo', 'Material Permanente', 'Receitas', 'Reserva técnica', 'Serviços de terceiros', 'Sem informação/indefinido', 'Taxa administrativa', 'Taxas bancárias/câmbio'];
                foreach($rubrics as $rubric){
                    Rubric::create([
                        'rubric' => $rubric,
                    ]);
                }
            }
            }catch(Exception $e){
            // Tratar erro de duplicidade ou outro erro
            Log::error('Erro ao criar status pela Seeder: ' . $e->getMessage());
        }
    }
}
