<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TypeMoviment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    // nome da tabela
    protected $table = 'type_moviment';
    // campos que podem ser preenchidos/manipulados
    protected $fillable = ['type'];

    //Relcaionamento com movimentacao
    public function Moviment()
    {
        return $this->hasMany(Moviment::class, 'type');
    }
}
