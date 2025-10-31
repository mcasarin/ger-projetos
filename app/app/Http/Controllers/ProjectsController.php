<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class ProjectsController extends Controller
{
    // Listar todos os projetos
    public function index() {
        // Recuperar registros do banco de dados
        $projects = Project::orderBy('id', 'asc')->paginate(5);
        // Salvando log
        Log::info('Lista de projetos acessada.');
        
        //Carregar a view
        return view('projects.index', ['projects' => $projects]);
    }
    
    // Detalhes do projeto
    public function show(Project $project) {
        // Salva log
        Log::info('Detalhes do projeto acessados.', ['project_id' => $project->id]);
        // Carregar a view com os detalhes do projeto
        return view('projects.show', ['project' => $project]);
    }

    // Formulário para criar um novo projeto
    public function create() {
        //Carregar a view
        return view('projects.create');
    }

    public function store(Request $request) {
        // dd($request->all()); // Imprime todos os dados recebidos do formulário
        // Pega o usuário da sessão, temporariamente fixo
        $userId = "1"; // Substitua pelo ID do usuário autenticado
        // Validar os dados recebidos do formulário
        try {
            $project = Project::create([
                'name' => $request->name,
                'description' => $request->description,
                'initial_budget' => $request->initial_budget,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'project_manager' => $request->project_manager,
                // 'status' => $request->input('status'),
                'owner_id' => $userId
            ]);
            // Salva log
            Log::info('Novo projeto cadastrado.', ['project_id' => $project->id]);
            // Criar o novo projeto no banco de dados
            //$project = \App\Models\Project::create($validatedData);

            // Redirecionar para a lista de projetos com uma mensagem de sucesso
            return redirect()->route('projects.show', ['project' => $project->id])->with('success', 'Projeto cadastrado com sucesso!');
        } catch (Exception $e) {
            // salva log de erro
            Log::notice('Erro ao cadastrar novo projeto.', ['error' => $e->getMessage()]);
        }
        // Redirecionar para a lista de projetos com uma mensagem de sucesso
        return back()->withInput()->with('error', 'Projeto não cadastrado!!!');
    }

    // Formulário para editar um projeto existente
    public function edit(Project $project) {
        // Carregar a view com o formulário de edição
        return view('projects.edit', ['project' => $project]);
    }

    public function update(Request $request, Project $project) {
        $userId = "1"; // Substitua pelo ID do usuário autenticado
        // Validar os dados recebidos do formulário
        try{
        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'initial_budget' => $request->initial_budget,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'project_manager' => $request->project_manager,
            // 'status' => 'nullable|string|max:50',
            'owner_id' => $userId
        ]);
        // salva log
        Log::info('Projeto editado.', ['project_id' => $project->id]);

        return redirect()->route('projects.show', ['project' => $project->id])->with('success', 'Projeto editado com sucesso!');

        } catch (Exception $e) {
            // salva log de erro
            Log::notice('Erro ao editar projeto.', ['project_id' => $project->id, 'error' => $e->getMessage()]);
            // Redirecionar para a lista de projetos com uma mensagem de sucesso
            return back()->withInput()->with('error', 'Projeto não editado!!!');
        }
    }

    public function destroy(Project $project) {
        try {
            $project->delete();
            return redirect()->route('projects.index')->with('success', 'Projeto excluído com sucesso!');
            // salva log
            Log::info('Projeto excluído.', ['project_id' => $project->id]);
        } catch (Exception $e) {
            // salva log de erro
            Log::notice('Erro ao excluir projeto.', ['project_id' => $project->id, 'error' => $e->getMessage()]);
            return redirect()->route('projects.index')->with('error', 'Erro ao excluir o projeto.');
        }
    }
}