<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\StatusProj;
use Illuminate\Support\Facades\Auth;
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
        Log::info('Lista de projetos acessada.', ['user_id' => Auth::id()]);
        
        //Carregar a view
        return view('projects.index', ['projects' => $projects]);
    }
    
    // Detalhes do projeto
    public function show(Project $project) {
        // Salva log
        Log::info('Detalhes do projeto acessados.', ['project_id' => $project->id]);
        // Carregar a view com os detalhes do projeto
        return view('projects.show', ['project' => $project, 'user_id' => Auth::id()]);
    }

    // Formulário para criar um novo projeto
    public function create() {
        // Carrega todos os projetos existentes para serem opções de "Projeto Pai".
        $listProjects = Project::all();
        //Carregar a view
        return view('projects.create', [
            'listProjects' => $listProjects,
        ]);
    }

    public function store(Request $request) {
        // dd($request->all()); // Imprime todos os dados recebidos do formulário
        
        // 1. Validação dos dados (se falhar, redireciona automaticamente com erros)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'initial_budget' => 'nullable|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'project_manager' => 'nullable|string|max:255',
            // NOVO CAMPO: Opcional e deve existir na tabela projects (ou ser nulo)
            'parent_id' => 'nullable|exists:projects,id', 
        ]);
        // Salva log de dados validados
        Log::info('Dados validados com sucesso para novo projeto.', $validatedData);
        // Validar os dados recebidos do formulário
        try {
            // Adiciona campos que não vêm do formulário, mas são necessários
            $validatedData['owner_id'] = 1;
            // Cria o novo projeto usando os dados validados
            $project = Project::create($validatedData);
            // Salva log
            Log::info('Novo projeto cadastrado.', ['project_id' => $project->id, 'user_id' => Auth::id()]);
        
            return redirect()->route('projects.show', ['project' => $project->id])->with('success', 'Projeto cadastrado com sucesso!');
        } catch (Exception $e) {
            // Salva log de erro de PERSISTÊNCIA (após a validação)
            Log::notice('Erro ao cadastrar novo projeto (Erro de persistência).', ['error' => $e->getMessage(), 'data' => $validatedData, 'user_id' => Auth::id()]);
            
            return back()->withInput()->with('error', 'Projeto não cadastrado!!!');
        }
    }

    // Formulário para editar um projeto existente
    public function edit(Project $project) {
        $statusProj = StatusProj::all();
        // Carrega todos os projetos, EXCLUINDO o projeto atual 
        // para evitar que um projeto seja pai de si mesmo (loop).
        $listProjects = Project::where('id', '!=', $project->id)->get();
        // Carregar a view com o formulário de edição
        return view('projects.edit', [
            'project' => $project,
            'listProjects' => $listProjects, // Passar a lista para a view
            'statusProj' => $statusProj,
        ]);
    }

    public function update(Request $request, Project $project) {
        // 1. Validação dos dados
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'initial_budget' => 'nullable|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'project_manager' => 'nullable|string|max:255',
            'status' => 'required|integer', // Adicionei para consistência
            // NOVO CAMPO: Deve existir, ser opcional E NÃO SER O PRÓPRIO ID DO PROJETO.
            'parent_id' => [
                'nullable',
                'exists:projects,id',
                'not_in:' . $project->id // IMPEDE self-parenting
            ],
        ]);
        
        Log::info('Dados validados com sucesso para atualização.', ['project_id' => $project->id, 'data' => $validatedData]);
        try{
        // 2. Atualiza o projeto com os dados validados
        // O owner_id (proprietário) não é alterado, pois não deve ser manipulado pelo formulário de edição.
        $project->update($validatedData);
        
        // salva log
        Log::info('Projeto editado =>', ['project_id' => $project->id, 'usuário_id' => Auth::id()]);

        return redirect()->route('projects.show', ['project' => $project->id])->with('success', 'Projeto editado com sucesso!');

        } catch (Exception $e) {
            // salva log de erro
            Log::notice('Erro ao editar projeto (Erro de persistência).', ['project_id' => $project->id, 'error' => $e->getMessage(), 'data' => $validatedData]);
            
            return back()->withInput()->with('error', 'Projeto não editado!!!');
        }
    }

    public function destroy(Project $project) {
        try {
            $project->delete();
            return redirect()->route('projects.index')->with('success', 'Projeto excluído com sucesso!');
            // salva log
            Log::info('Projeto excluído.', ['project_id' => $project->id, 'user_id' => Auth::id()]);
        } catch (Exception $e) {
            // salva log de erro
            Log::notice('Erro ao excluir projeto.', ['project_id' => $project->id, 'user_id' => Auth::id(), 'error' => $e->getMessage()]);
            return redirect()->route('projects.index')->with('error', 'Erro ao excluir o projeto.');
        }
    }
}