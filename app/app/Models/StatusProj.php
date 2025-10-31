<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StatusProj extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    // nome da tabela
    protected $table = 'status_proj';
    // campos que podem ser preenchidos/manipulados
    protected $fillable = ['status'];

    // Cirar relacionamento com a tabela de projetos
    public function projects()
    {
        return $this->hasMany(Project::class, 'status');
    }
}
