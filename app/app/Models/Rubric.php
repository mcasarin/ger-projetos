<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Rubric extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    // nome da tabela
    protected $table = 'rubrics';
    // campos que podem ser preenchidos/manipulados
    protected $fillable = ['rubric'];

    //Relacionamento com movimentacao
    public function Moviment()
    {
        return $this->hasMany(Moviment::class, 'rubric');
    }
}
