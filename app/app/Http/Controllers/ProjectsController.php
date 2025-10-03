<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    // Listar todos os projetos
    public function index() {
        //Carregar a view
        return view('projects.index');
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
        Project::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'initial_budget' => $request->input('initial_budget'),
            // 'start_date' => $request->input('start_date'),
            // 'end_date' => $request->input('end_date'),
            // 'status' => $request->input('status'),
            'owner_id' => $userId
        ]);

        // Criar o novo projeto no banco de dados
        //$project = \App\Models\Project::create($validatedData);

        // Redirecionar para a lista de projetos com uma mensagem de sucesso
        return redirect()->route('projects.index')->with('success', 'Projeto cadastrado com sucesso!');
    }
}
