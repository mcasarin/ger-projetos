<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeMovim extends Model
{
    // nome da tabela
    protected $table = 'type_movim';
    // campos que podem ser preenchidos/manipulados
    protected $fillable = ['tipo'];
}
