<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StatusUser extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    // nome da tabela
    protected $table = 'status_user';
    // campos que podem ser preenchidos/manipulados
    protected $fillable = ['status'];

    // Relacionamento com usuarios
    public function User()
    {
        return $this->hasMany(User::class, 'status');
    }
}

