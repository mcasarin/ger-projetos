<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    // nome da tabela
    protected $table = 'movimentacoes_financeira';
    // campos que podem ser preenchidos/manipulados
    protected $fillable = ['descricao','valor', 'tipo','data_movimentacao', 'project_id'];
}
