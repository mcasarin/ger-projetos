<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // nome da tabela
    protected $table = 'projects';
    // campos que podem ser preenchidos/manipulados
    protected $fillable = ['name','description','initial_budget','start_date','end_date','project_manager','status','owner_id'];
}
