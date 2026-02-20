<?php

namespace App\Models;

use OwenIt\Auditing\Models\Audit as BaseAudit;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditReport extends BaseAudit
{
    // Opcional: se quiser customizar o nome da tabela
    protected $table = 'audits';

    /**
     * Relacionamento com o usuário que executou a ação.
     * A coluna padrão é user_id, e o pacote já grava isso (user resolver).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Relacionamento polymorphic com o modelo auditado.
     * Já vem pronto na model base, mas aqui deixamos explícito.
     */
    public function auditable()
    {
        return $this->morphTo();
    }
}

