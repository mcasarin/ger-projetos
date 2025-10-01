<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusProj extends Model
{
    // nome da tabela
    protected $table = 'status_proj';
    // campos que podem ser preenchidos/manipulados
    protected $fillable = ['status'];
}
