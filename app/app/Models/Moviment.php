<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Project;

class Moviment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    // nome da tabela
    protected $table = 'financial_moviments';
    // campos que podem ser preenchidos/manipulados
    protected $fillable = ['description','amount', 'type','moviment_date', 'project_id'];

    // Relacionamento com projetos
    public function projectRel()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    // Relacionamento com tipo movimentacao
    public function typeMoviment()
    {
        return $this->belongsTo(TypeMoviment::class, 'type', 'id');
    }
}
