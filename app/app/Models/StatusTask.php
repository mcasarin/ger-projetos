<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusTask extends Model
{
    // nome da tabela
    protected $table = 'status_task';
    // campos que podem ser preenchidos/manipulados
    protected $fillable = ['status'];
}
