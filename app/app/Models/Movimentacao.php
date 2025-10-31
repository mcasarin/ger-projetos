<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Movimentacao extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    // nome da tabela
    protected $table = 'movimentacoes_financeira';
    // campos que podem ser preenchidos/manipulados
    protected $fillable = ['descricao','valor', 'tipo','data_movimentacao', 'project_id'];

    // Relacionamento com projetos
    public function projectRel()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    // Relacionamento com tipo movimentacao
    public function tipoMovimentacao()
    {
        return $this->belongsTo(TypeMovim::class, 'tipo');
    }
}
