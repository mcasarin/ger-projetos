<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moviment;
use App\Models\TypeMoviment;
use App\Models\Rubric;
use App\Models\Project;
use App\Models\Beneficiary;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class MovimentsController extends Controller
{
    // Listar todas as movimentos
    public function index() {
        // Recuperar registros do banco de dados
        $moviments = Moviment::orderBy('id', 'asc')->paginate(5);
        // Salvando log
        Log::info('Lista de movimentações financeiras acessada.');
        
        //Carregar a view
        return view('moviments.index', ['menu' => 'moviments', 'moviments' => $moviments]);
    }
    
    // Detalhes da movimento
    public function show(Moviment $moviment) {
        // Salva log
        Log::info('Detalhes da movimento acessados.', ['moviment_id' => $moviment->id]);
        //$moviment->load('typeMoviment', 'typeMoviment');
        // Carregar a view com os detalhes do projeto
        return view('moviments.show', ['menu' => 'moviments', 'moviment' => $moviment, 'user_id' => Auth::id() ]);
    }

    // Formulário para criar uma nova movimentação financeira
    public function create() {
        //Carregar a view com coleta dos status para as tasks e lista projetos para associação
        $listTypes = TypeMoviment::all();
        $listRubrics = Rubric::all();
        $listProjects = Project::all();
        $listBeneficiaries = Beneficiary::orderBy('name')->limit(10)->get();
        
        return view('moviments.create', [
            'listProjects' => $listProjects,
            'listTypes' => $listTypes,
            'listRubrics' => $listRubrics,
            'listBeneficiaries' => $listBeneficiaries,
        ]);
    }

    public function store(Request $request, Moviment $moviment) {
        //dd($request->all()); // Imprime todos os dados recebidos do formulário

        // IMPORTANTE: Limpa máscara ANTES da validação
        $request->merge([
            'beneficiary_document' => preg_replace('/\D/', '', $request->beneficiary_document ?? ''),
        ]);
        // Validar os dados recebidos do formulário
        $validatedData = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'description' => 'nullable|string',
            'type' => 'required|exists:type_moviment,id',
            'rubric' => 'required|exists:rubrics,id',
            'amount' => 'required|numeric|min:0',
            'moviment_date' => 'required|date', // Valida que é uma data válida
            'beneficiary_name' => 'required|string|max:255',
            'beneficiary_document' => [
            'required',
            'string',
            'min:11',
            'max:14',
            'regex:/^(\d{11}|\d{14})$/',
            ],
        ]);
        // grava validação no log
        Log::info('Dados validados com sucesso para cadastro de movimento financeiro.', $validatedData);
        try {
            // Busca ou cria beneficiário
            $cleanDoc = preg_replace('/[^0-9]/', '', $validatedData['beneficiary_document']);
            $documentType = strlen($cleanDoc) === 11 ? 'cpf' : 'cnpj';
            
            $beneficiary = Beneficiary::firstOrCreate(
                ['document' => $cleanDoc],
                [
                    'name' => $validatedData['beneficiary_name'],
                    'document_type' => $documentType
                ]
            );
            // 1. Cria a movimentação
            $moviment = Moviment::create(array_merge($validatedData, [
                'beneficiary_id' => $beneficiary->id
            ]));
            // 2. Busca o projeto e Recalcula os totais
            $project = Project::find($moviment->project_id);
            $project->recalculateFinancials(); // Chama o método de atualização
            
            // Salva log
            Log::info('Novo movimento financeiro cadastrado.', ['moviment_id' => $moviment->id, 'user_id' => Auth::id()]);
            
            // Redirecionar para a lista de movimentos com uma mensagem de sucesso
            return redirect()->route('moviments.show', ['moviment' => $moviment->id])->with('success', 'Movimento financeiro cadastrado com sucesso!');
        } catch (Exception $e) {
            // salva log de erro
            Log::notice('Erro ao cadastrar novo movimento financeiro [Err 1].', ['error' => $e->getMessage(), 'user_id' => Auth::id()]);
        }
        // Redirecionar para a lista de movimentos com uma mensagem de erro
        return back()->withInput()->with('error', 'Movimento financeiro não cadastrado!!! [Err 2]');
    }

    // Formulário para editar um movimento existente
    public function edit(Moviment $moviment) {
        // Carregar a view com o formulário de edição
        $listProjects = Project::all();
        $listTypes = TypeMoviment::all();
        $listRubrics = Rubric::all();
        return view('moviments.edit', [
            'menu' => 'moviments',
            'moviment' => $moviment,
            'listProjects' => $listProjects,
            'listTypes' => $listTypes,
            'listRubrics' => $listRubrics
        ]);
    }

    public function update(Request $request, Moviment $moviment)
    {
        $validatedData = $request->validate([
            'description' => 'nullable|string',
            'type' => 'required|exists:type_moviment,id',
            'rubric' => 'required|exists:rubrics,id',
            'amount' => 'required|numeric',
            'moviment_date' => 'required|date',
            'project_id' => 'required|exists:projects,id',
            // Campos do beneficiário
            'beneficiary_name' => 'nullable|string|max:255',
            'beneficiary_document' => 'nullable|string',
        ]);

        try {
            // Lógica para o Beneficiário
            if ($request->filled('beneficiary_name')) {
                $cleanDoc = preg_replace('/\D/', '', $request->beneficiary_document);
                
                // Busca por documento ou cria um novo se não existir
                $beneficiary = Beneficiary::firstOrCreate(
                    ['document' => $cleanDoc],
                    [
                        'name' => $validatedData['beneficiary_name'],
                        'document_type' => strlen($cleanDoc) === 11 ? 'cpf' : 'cnpj'
                    ]
                );
                
                $moviment->beneficiary_id = $beneficiary->id;
            } 
            // Se você quiser que "vazio" remova o beneficiário atual, descomente a linha abaixo:
            // else { $moviment->beneficiary_id = null; }

            $moviment->update($validatedData);

            return redirect()->route('moviments.show', $moviment->id)
                            ->with('success', 'Movimentação atualizada com sucesso!');

        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Erro ao atualizar: ' . $e->getMessage());
        }
    }

    public function destroy(Moviment $moviment) {
        try {
            $moviment->delete();
            // salva log
            Log::info('Movimentação excluída.', ['moviment_id' => $moviment->id, 'user_id' => Auth::id()]);
            return redirect()->route('moviments.index')->with('success', 'Movimentação excluída com sucesso!');
            
        } catch (Exception $e) {
            // salva log de erro
            Log::notice('Erro ao excluir a movimentação. [Err 1]', ['moviment_id' => $moviment->id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);
            return redirect()->route('moviments.index')->with('error', 'Erro ao excluir a movimentação. [Err 2]');
        }
    }

        public function sheet(Request $request)
        {
            $sortField = $request->get('sort', 'moviment_date');
            $sortDirection = $request->get('direction', 'asc');

            $validFields = ['moviment_date', 'amount', 'id', 'type'];
            $sortField = in_array($sortField, $validFields) ? $sortField : 'moviment_date';

            // 1. Iniciamos a Query Base para aplicar os filtros uma única vez
            $baseQuery = Moviment::query();

            // 2. Aplicação dos Filtros na Query Base
            if ($request->filled('project_id')) {
                $baseQuery->where('project_id', $request->project_id);
            }
            
            // Verifique se a coluna no banco é 'type' ou 'type_moviment_id'
            // Se no seu banco o ID do tipo fica em 'type', mantenha assim:
            if ($request->filled('type')) {
                $baseQuery->where('type', $request->type);
            }

            if ($request->filled('search_beneficiary')) {
                $search = $request->search_beneficiary;
                $searchDigits = preg_replace('/\D/', '', $search);

                // Onde existir o beneficiário, filtra por nome ou documento
                $baseQuery->whereHas('beneficiary', function($q) use ($search, $searchDigits) {
                    $q->where(function($sub) use ($search, $searchDigits) {
                        $sub->where('name', 'like', "%{$search}%");
                        if (!empty($searchDigits)) {
                            $sub->orWhere('document', 'like', "%{$searchDigits}%");
                        }
                    });
                });
            }

            if ($request->filled('date_from')) {
                $baseQuery->whereDate('moviment_date', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $baseQuery->whereDate('moviment_date', '<=', $request->date_to);
            }

            // 3. Cálculos de Totais usando CLONE da Query Base (Garante que os filtros sejam idênticos)
            // Importante: use a coluna correta para identificar tipo 1 (entrada) e 2 (saída)
            $totalRevenuesGlobal = (clone $baseQuery)->where('type', 1)->sum('amount');
            $totalExpensesGlobal = (clone $baseQuery)->where('type', 2)->sum('amount');

            // 4. Execução da listagem principal com os relacionamentos
            $moviments = (clone $baseQuery)
                ->with(['projectRel', 'typeMoviment', 'toProject', 'beneficiary'])
                ->orderBy($sortField, $sortDirection)
                ->paginate(25);

            // 5. Preparação dos dados para os selects da view
            $projects = Project::select('id', 'name', 'initial_budget')->orderBy('name')->get();
            $types = TypeMoviment::select('id', 'type')->orderBy('type')->get();
            $beneficiaries = Beneficiary::select('id', 'name')->orderBy('name')->get();

            Log::info('Planilha financeira acessada.', [
                'filters' => $request->only(['project_id', 'type', 'date_from', 'date_to', 'search_beneficiary']),
                'totals' => ['revenues' => $totalRevenuesGlobal, 'expenses' => $totalExpensesGlobal]
            ]);

            return view('moviments.sheet', array_merge(compact(
                'moviments', 'projects', 'types', 'beneficiaries',
                'totalRevenuesGlobal', 'totalExpensesGlobal'
            ), ['menu' => 'sheet']));
        }

        // Eager loading no sheet()
        public function scopeWithRelations($query)
        {
            return $query->with(['projectRel', 'typeMoviment', 'toProject', 'beneficiary']);
        }
}
