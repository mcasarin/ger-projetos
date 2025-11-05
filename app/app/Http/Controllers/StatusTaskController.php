<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatusTask;

class StatusTaskController extends Controller
{
    public function index() {
        // Recuperar registros do banco de dados
        $status_task = StatusTask::orderBy('id', 'asc')->get();

        //Carregar a view
        return view('status_tasks.index',['status_task' => $status_task]);
    }
    public function create() {
        //Caregar a view
        return view('status_tasks.create');
    }

    public function store(Request $request) {
        // dd($request->all()); // Imprime todos os dados recebidos do formulário
        // Validar os dados recebidos do formulário
        StatusTask::create([
            'status' => $request->input('status')
        ]);

        // Redirecionar para a lista de status com uma mensagem de sucesso
        return redirect()->route('status_tasks.index')->with('success', 'Status cadastrado com sucesso!');
    }
}
