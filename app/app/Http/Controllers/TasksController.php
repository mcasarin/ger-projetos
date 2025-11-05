<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\StatusTask;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class TasksController extends Controller
{
    // Listar todas as tarefas
    public function index() {
        // Recuperar registros do banco de dados
        $tasks = Task::orderBy('id', 'asc')->paginate(5);
        // Salvando log
        Log::info('Lista de tarefas acessada.');
        
        //Carregar a view
        return view('tasks.index', ['tasks' => $tasks]);
    }
    
    // Detalhes da tarefa
    public function show(Task $task) {
        // Salva log
        Log::info('Detalhes da tarefa acessados.', ['task_id' => $task->id]);
        $task->load('statusRelTask', 'owner');
        // Carregar a view com os detalhes do projeto
        return view('tasks.show', ['task' => $task]);
    }

    // Formulário para criar uma nova tarefa
    public function create() {
        //Carregar a view com coleta dos status para as tasks e lista projetos para associação
        $statusTasks = StatusTask::all();
        $listProjects = Project::all();
        $listUsers = User::all();
        return view('tasks.create', [
            'statusTasks' => $statusTasks, 
            'listProjects' => $listProjects,
            'listUsers' => $listUsers
        ]);
    }

    public function store(Request $request, Task $task) {
        //dd($request->all()); // Imprime todos os dados recebidos do formulário
        // Validar os dados recebidos do formulário
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'owner_id' => 'required|exists:users,id',
            'status' => 'required|exists:status_task,id',
            'start_date' => 'required|date', // Valida que é uma data válida
            'due_date' => 'nullable|date|after:start_date',
            'project_id' => 'required|exists:projects,id',
        ]);
        // grava validação no log
        Log::info('Dados validados com sucesso para nova tarefa.', $validatedData);
        try {
            $task = Task::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'owner_id' => $validatedData['owner_id'],
                'status' => $validatedData['status'],
                'project_id' => $validatedData['project_id'],
                'start_date' => $validatedData['start_date'],
                'due_date' => $validatedData['due_date'],
            ]);
            // Salva log
            Log::info('Novo tarefa cadastrada.', ['task_id' => $task->id]);
            
            // Redirecionar para a lista de tarefas com uma mensagem de sucesso
            return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Tarefa cadastrada com sucesso!');
        } catch (Exception $e) {
            // salva log de erro
            Log::notice('Erro ao cadastrar nova tarefa [Err 1].', ['error' => $e->getMessage()]);
        }
        // Redirecionar para a lista de tarefas com uma mensagem de erro
        return back()->withInput()->with('error', 'Tarefa não cadastrado!!! [Err 2]');
    }

    // Formulário para editar um tarefa existente
    public function edit(Task $task) {
        // Carregar a view com o formulário de edição
        $statusTasks = StatusTask::all();
        $listProjects = Project::all();
        $listUsers = User::all();
        return view('tasks.edit', [
            'task' => $task,
            'statusTasks' => $statusTasks, 
            'listProjects' => $listProjects,
            'listUsers' => $listUsers
        ]);
    }

    public function update(Request $request, Task $task) {
        // Validar os dados recebidos do formulário
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'owner_id' => 'required|exists:users,id',
            'status' => 'required|exists:status_task,id',
            'start_date' => 'required|date', // Valida que é uma data válida
            'due_date' => 'nullable|date|after:start_date',
            'project_id' => 'required|exists:projects,id',
        ]);
        try {
            $task->update([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'owner_id' => $validatedData['owner_id'],
                'status' => $validatedData['status'],
                'project_id' => $validatedData['project_id'],
                'start_date' => $validatedData['start_date'],
                'due_date' => $validatedData['due_date'],
            ]);
        // salva log
        Log::info('Tarefa editada. ', ['task_id' => $task->id]);

        return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Tarefa editada com sucesso!');

        } catch (Exception $e) {
            // salva log de erro
            Log::notice('Erro ao editar tarefa.', ['task_id' => $task->id, 'error' => $e->getMessage()]);
            // Redirecionar para a lista de tarefas com uma mensagem de erro
            return back()->withInput()->with('error', 'Tarefa não editada!!!');
        }
    }

    public function destroy(Task $task) {
        try {
            $task->delete();
            // salva log
            Log::info('Tarefa excluída.', ['task_id' => $task->id]);
            return redirect()->route('tasks.index')->with('success', 'Tarefa excluída com sucesso!');
            
        } catch (Exception $e) {
            // salva log de erro
            Log::notice('Erro ao excluir tarefa.', ['task_id' => $task->id, 'error' => $e->getMessage()]);
            return redirect()->route('tasks.index')->with('error', 'Erro ao excluir o tarefa.');
        }
    }
}
