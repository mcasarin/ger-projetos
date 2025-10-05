<?php

namespace App\Http\Controllers;
use App\Models\StatusProj;
use Illuminate\Http\Request;

class StatusProjsController extends Controller
{
    public function index() {
        // Recuperar registros do banco de dados
        $status_proj = StatusProj::orderBy('id', 'asc')->get();

        //Carregar a view
        return view('status_projs.index',['status_proj' => $status_proj]);
    }
    public function create() {
        //Caregar a view
        return view('status_projs.create');
    }

    public function store(Request $request) {
        // dd($request->all()); // Imprime todos os dados recebidos do formulário
        // Validar os dados recebidos do formulário
        StatusProj::create([
            'status' => $request->input('status')
        ]);

        // Redirecionar para a lista de status com uma mensagem de sucesso
        return redirect()->route('status_projs.index')->with('success', 'Status cadastrado com sucesso!');
    }
}
