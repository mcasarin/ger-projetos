<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TypeMovim extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    // nome da tabela
    protected $table = 'type_movim';
    // campos que podem ser preenchidos/manipulados
    protected $fillable = ['tipo'];

    //Relcaionamento com movimentacao
    public function Movimentacao()
    {
        return $this->hasMany(Movimentacao::class, 'tipo');
    }
}
