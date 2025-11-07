<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Exception;
use App\Models\TypeMoviment;

class TypeMovimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try{
            $count = TypeMoviment::count();
            if($count > 0){
                return; // Já existem registros, não faz nada
            } else {
                $tipos = ['Entrada', 'Saída', 'Transferência'];
                foreach($tipos as $tipo){
                    TypeMoviment::create([
                        'type' => $tipo,
                    ]);
                }
            }
            }catch(Exception $e){
            // Tratar erro de duplicidade ou outro erro
            // Log::error('Erro ao criar status: ' . $e->getMessage());
        }
    }
}
