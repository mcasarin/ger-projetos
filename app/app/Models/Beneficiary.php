<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Beneficiary extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'document', 'document_type'];

    protected $casts = [
        'document_type' => 'string'
    ];

    // Scope para busca por documento
    public function scopeByDocument($query, $document)
    {
        return $query->whereRaw('REGEXP_REPLACE(document, "[^0-9]", "") = REGEXP_REPLACE(?, "[^0-9]", "")', [$document]);
    }

    // Relacionamento com Moviment
    public function moviments()
    {
        return $this->hasMany(Moviment::class);
    }

    // Acessors para formatar documento
    public function getFormattedDocumentAttribute()
    {
        $doc = preg_replace('/[^0-9]/', '', $this->document);
        if (strlen($doc) === 11) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", $doc);
        }
        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "$1.$2.$3/$4-$5", $doc);
    }

    // Anonimizar de cpf e cnpj
    public function getAnonymizedDocumentAttribute()
    {
        $doc = $this->formatted_document; // Assume que já vem formatado
        if (!$doc) return '-';

        // Máscara mantendo os 3 primeiros dígitos e os 2 últimos
        return substr($doc, 0, 3) . '.***.***-' . substr($doc, -2);
    }
}
