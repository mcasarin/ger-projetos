<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use \OwenIt\Auditing\Auditable;

    // nome da tabela
    protected $table = 'tasks';
    // campos que podem ser preenchidos/manipulados
    protected $fillable = ['title','description','owner_id', 'status','project_id', 'start_date', 'due_date'];
}
