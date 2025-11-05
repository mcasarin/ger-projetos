<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Task extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    // nome da tabela
    protected $table = 'tasks';
    // campos que podem ser preenchidos/manipulados
    protected $fillable = ['title','description','owner_id','status','project_id','start_date','due_date'];
    // O 'date' fará o cast para um objeto Carbon, tornando fácil a manipulação de data/hora.
    protected $casts = [
        'start_date' => 'datetime', 
        'due_date' => 'datetime',
    ];

    public function statusRelTask()
    {
        return $this->belongsTo(StatusTask::class, 'status', 'id');
    }

    public function Project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function owner()
    {
        // O primeiro argumento é a Model relacionada (User::class).
        // O segundo argumento é a coluna local na tabela 'tasks' (owner_id).
        // O terceiro argumento (opcional) é a chave na tabela 'users' (id).
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
}
