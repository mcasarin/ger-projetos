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
    protected $fillable = ['description','amount', 'type','moviment_date', 'project_id', 'to_project_id'];

    // Casts para formatação automática
    protected $casts = [
        'moviment_date' => 'date',
        'amount' => 'decimal:2',
    ];

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

    // Relacionamento para transferências (projeto destino)
    public function toProject()
    {
        return $this->belongsTo(Project::class, 'to_project_id');
    }
}
