<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeMoviment;
use Exception;

class TypeMovimentController extends Controller
{
    public function index() {
        // Recuperar registros do banco de dados
        $type_moviment = TypeMoviment::orderBy('id', 'asc')->get();

        //Carregar a view
        return view('type_moviments.index',['type_moviments' => $type_moviment]);
    }
    public function create() {
        //Caregar a view
        return view('type_moviments.create');
    }

    public function store(Request $request) {
        // dd($request->all()); // Imprime todos os dados recebidos do formulário
        // Validar os dados recebidos do formulário
        TypeMoviment::create([
            'type' => $request->input('type')
        ]);

        // Redirecionar para a lista de tipos de movimentos com uma mensagem de sucesso
        return redirect()->route('type_moviments.index')->with('success', 'Tipo cadastrado com sucesso!');
    }
}
