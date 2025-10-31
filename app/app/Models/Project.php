<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    // nome da tabela
    protected $table = 'projects';
    // campos que podem ser preenchidos/manipulados
    protected $fillable = ['name','description','initial_budget','start_date','end_date','project_manager','status','owner_id'];

    public function statusRel()
    {
        return $this->belongsTo(StatusProj::class, 'status');
    }

    public function Movimentacao()
    {
        return $this->hasMany(Movimentacao::class, 'project_id');
    }
}
