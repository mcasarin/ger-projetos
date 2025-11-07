<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moviment;
use App\Models\TypeMoviment;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
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
        return view('moviments.index', ['moviments' => $moviments]);
    }
    
    // Detalhes da movimento
    public function show(Moviment $moviment) {
        // Salva log
        Log::info('Detalhes da movimento acessados.', ['moviment_id' => $moviment->id]);
        //$moviment->load('typeMoviment', 'typeMoviment');
        // Carregar a view com os detalhes do projeto
        return view('moviments.show', ['moviment' => $moviment]);
    }

    // Formulário para criar uma nova movimentação financeira
    public function create() {
        //Carregar a view com coleta dos status para as tasks e lista projetos para associação
        $listTypes = TypeMoviment::all();
        $listProjects = Project::all();
        
        return view('moviments.create', [ 
            'listProjects' => $listProjects,
            'listTypes' => $listTypes
        ]);
    }

    public function store(Request $request, Moviment $moviment) {
        //dd($request->all()); // Imprime todos os dados recebidos do formulário
        // Validar os dados recebidos do formulário
        $validatedData = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'description' => 'nullable|string',
            'type' => 'required|in:1,2',
            'amount' => 'required',
            'moviment_date' => 'required|date', // Valida que é uma data válida
        ]);
        // grava validação no log
        Log::info('Dados validados com sucesso para cadastro de movimento financeiro.', $validatedData);
        try {
            // 1. Cria a movimentação
            $moviment = Moviment::create($validatedData);
            // 2. Busca o projeto e Recalcula os totais
            $project = Project::find($moviment->project_id);
            $project->recalculateFinancials(); // Chama o método de atualização
            // Salva log
            Log::info('Novo movimento financeiro cadastrado.', ['moviment_id' => $moviment->id]);
            
            // Redirecionar para a lista de movimentos com uma mensagem de sucesso
            return redirect()->route('moviments.show', ['moviment' => $moviment->id])->with('success', 'Movimento financeiro cadastrado com sucesso!');
        } catch (Exception $e) {
            // salva log de erro
            Log::notice('Erro ao cadastrar novo movimento financeiro [Err 1].', ['error' => $e->getMessage()]);
        }
        // Redirecionar para a lista de movimentos com uma mensagem de erro
        return back()->withInput()->with('error', 'Movimento financeiro não cadastrado!!! [Err 2]');
    }

    // Formulário para editar um movimento existente
    public function edit(Moviment $moviment) {
        // Carregar a view com o formulário de edição
        $typeMoviment = TypeMoviment::all();
        $listProjects = Project::all();
        $listTypes = TypeMoviment::all();
        return view('moviments.edit', [
            'moviment' => $moviment,
            'listProjects' => $listProjects,
            'listTypes' => $listTypes
        ]);
    }

    public function update(Request $request, Moviment $moviment) {
        // Validar os dados recebidos do formulário
        $validatedData = $request->validate([
            'description' => 'nullable|string',
            'type' => 'required|exists:type_moviment,id',
            'amount' => 'required',
            'moviment_date' => 'required|date', // Valida que é uma data válida
            'project_id' => 'required|exists:projects,id',
        ]);
        try {
            $moviment->update([
                'description' => $validatedData['description'],
                'type' => $validatedData['type'],
                'amount' => $validatedData['amount'],
                'moviment_date' => $validatedData['moviment_date'],
                'project_id' => $validatedData['project_id'],
            ]);
        // salva log
        Log::info('Movimentação editada. ', ['moviment_id' => $moviment->id]);

        return redirect()->route('moviments.show', ['moviment' => $moviment->id])->with('success', 'Movimentação editada com sucesso!');

        } catch (Exception $e) {
            // salva log de erro
            Log::notice('Erro ao editar a movimentação.', ['moviment_id' => $moviment->id, 'error' => $e->getMessage()]);
            // Redirecionar para a lista de movimentações com uma mensagem de erro
            return back()->withInput()->with('error', 'Movimentação não editada!!!');
        }
    }

    public function destroy(Moviment $moviment) {
        try {
            $moviment->delete();
            // salva log
            Log::info('Movimentação excluída.', ['moviment_id' => $moviment->id]);
            return redirect()->route('moviments.index')->with('success', 'Movimentação excluída com sucesso!');
            
        } catch (Exception $e) {
            // salva log de erro
            Log::notice('Erro ao excluir a movimentação. [Err 1]', ['moviment_id' => $moviment->id, 'error' => $e->getMessage()]);
            return redirect()->route('moviments.index')->with('error', 'Erro ao excluir a movimentação. [Err 2]');
        }
    }
}
