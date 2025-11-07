<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Log;

class Project extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    // nome da tabela
    protected $table = 'projects';
    // campos que podem ser preenchidos/manipulados
    protected $fillable = [
        'name','description','initial_budget','start_date','end_date','project_manager','status','owner_id', 'parent_id', 'total_revenues', 'total_expenses'
    ];

    public function statusRel()
    {
        return $this->belongsTo(StatusProj::class, 'status');
    }

    public function Movimentacao()
    {
        return $this->hasMany(Moviment::class, 'project_id');
    }

    // Relação UM PARA MUITOS (PAI): Um projeto C tem um pai B.
    public function parent()
    {
        return $this->belongsTo(Project::class, 'parent_id');
    }

    // Relação UM PARA MUITOS (FILHOS): Um projeto B pode ter vários filhos (C, D, etc.).
    public function children()
    {
        return $this->hasMany(Project::class, 'parent_id');
    }

    /**
    * Recalcula e salva o total de receitas e despesas com base nas movimentações.
    */
    public function recalculateFinancials(): void
    {
        // Log 1: Verifica se a função foi executada e qual é o ID do projeto
        Log::debug("Iniciando recalculo financeiro para o Projeto ID: " . $this->id);
        // Acessa o relacionamento Movimentacao()
        $totalRevenues = $this->Movimentacao()
            ->where('type', '1')
            ->sum('amount');

        $totalExpenses = $this->Movimentacao()
            ->where('type', '2')
            ->sum('amount');
        // Log 2: Mostra os valores calculados
        Log::debug("Valores calculados - Receita: R$ {$totalRevenues}, Despesa: R$ {$totalExpenses}");

        // Atualiza o projeto com os novos valores
        $updateResult = $this->update([
            'total_revenues' => $totalRevenues,
            'total_expenses' => $totalExpenses,
        ]);
        // Log 3: Confirma o sucesso ou falha da atualização
        if ($updateResult) {
            Log::info("Recalculo financeiro concluido com sucesso para o Projeto ID: " . $this->id);
        } else {
            // Se a atualização retornar false, verifique se total_revenue e total_expenses
            // estão no array $fillable da Model Project.
            Log::error("FALHA ao atualizar dados financeiros do Projeto ID: " . $this->id);
        }
    }
}
