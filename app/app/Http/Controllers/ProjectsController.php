<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Http\Request;
use Exception;

class ProjectsController extends Controller
{
    // Listar todos os projetos
    public function index() {
        // Recuperar registros do banco de dados
        $projects = Project::orderBy('id', 'asc')->get();
        
        //Carregar a view
        return view('projects.index', ['projects' => $projects]);
    }
    
    // Detalhes do projeto
    public function show(Project $project) {
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

        // Criar o novo projeto no banco de dados
        //$project = \App\Models\Project::create($validatedData);

        // Redirecionar para a lista de projetos com uma mensagem de sucesso
        return redirect()->route('projects.show', ['project' => $project->id])->with('success', 'Projeto cadastrado com sucesso!');
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

        return redirect()->route('projects.show', ['project' => $project->id])->with('success', 'Projeto editado com sucesso!');

        } catch (Exception $e) {
            // Redirecionar para a lista de projetos com uma mensagem de sucesso
            return back()->withInput()->with('error', 'Projeto não editado!!!');
        }
    }

    public function destroy(Project $project) {
        try {
            $project->delete();
            return redirect()->route('projects.index')->with('success', 'Projeto excluído com sucesso!');
        } catch (Exception $e) {
            return redirect()->route('projects.index')->with('error', 'Erro ao excluir o projeto.');
        }
    }
}