<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeMoviment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class TypeMovimentController extends Controller
{
    public function index() {
        // Recuperar registros do banco de dados
        $type_moviment = TypeMoviment::orderBy('id', 'asc')->get();
        Log::info('Lista de tipos de movimentos financeiros acessada.');
        //Carregar a view
        return view('type_moviments.index',['menu' => 'moviments','type_moviments' => $type_moviment]);
    }
    // Detalhes da tipo de movimento
    public function show(TypeMoviment $type_moviment) {
        // Salva log
        Log::info('Detalhes do tipo de movimento acessados.', ['type_moviment_id' => $type_moviment->id, 'user_id' => Auth::id()]);
        // Carregar a view com os detalhes do projeto
        return view('type_moviments.show', ['menu' => 'moviments', 'type_moviment' => $type_moviment]);
    }
    // Formulário para criar uma nova tipo de movimento
    public function create() {
        return view('type_moviments.create', ['menu' => 'moviments']);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'type' => 'required|string|max:255|unique:type_moviment,type',
        ], [
            'type.unique' => 'Este tipo de movimentação já está cadastrado.',
            'type.required' => 'O campo tipo é obrigatório.',
        ]);

        Log::info('Dados validados com sucesso para novo tipo de movimento.', $validatedData);

        try {
            $type_moviment = TypeMoviment::create([
                'type' => $validatedData['type']
            ]);

            Log::info('Novo tipo de movimento cadastrado.', [
                'type_moviment_id' => $type_moviment->id, 
                'user_id' => Auth::id()
            ]);
            
            return redirect()->route('type_moviments.show', ['type_moviment' => $type_moviment->id])
                            ->with('success', 'Tipo cadastrado com sucesso!');

        } catch (Exception $e) {
            Log::error('Erro ao cadastrar novo tipo de movimento.', [
                'error' => $e->getMessage(), 
                'user_id' => Auth::id()
            ]);

            return back()->withInput()->with('error', 'Erro interno ao processar cadastro.');
        }
    }

    public function edit(TypeMoviment $type_moviment) {
        return view('type_moviments.edit', [
            'menu' => 'moviments',
            'type_moviment' => $type_moviment
        ]);
    }

    public function update(Request $request, TypeMoviment $type_moviment) {
        $validatedData = $request->validate([
            'type' => 'required|string|max:255|unique:type_moviment,type,' . $type_moviment->id,
        ], [
            'type.unique' => 'Este tipo de movimentação já está cadastrado.',
            'type.required' => 'O campo tipo é obrigatório.',
        ]);

        Log::info('Dados validados com sucesso para atualização do tipo de movimento.', [
            'type_moviment_id' => $type_moviment->id,
            'validated_data' => $validatedData
        ]);

        try {
            $type_moviment->update([
                'type' => $validatedData['type']
            ]);

            Log::info('Tipo de movimento atualizado com sucesso.', [
                'type_moviment_id' => $type_moviment->id, 
                'user_id' => Auth::id()
            ]);

            return redirect()->route('type_moviments.show', ['type_moviment' => $type_moviment->id])
                            ->with('success', 'Tipo atualizado com sucesso!');

        } catch (Exception $e) {
            Log::error('Erro ao atualizar tipo de movimento.', [
                'error' => $e->getMessage(), 
                'type_moviment_id' => $type_moviment->id, 
                'user_id' => Auth::id()
            ]);

            return back()->withInput()->with('error', 'Erro interno ao processar atualização.');
        }
    }
        public function destroy(TypeMoviment $type_moviment) {
        try {
            $type_moviment->delete();
            // salva log
            Log::info('Tipo de Movimentação excluída.', ['type_moviment_id' => $type_moviment->id, 'user_id' => Auth::id()]);
            return redirect()->route('type_moviments.index')->with('success', 'Tipo de Movimentação excluída com sucesso!');
            
        } catch (Exception $e) {
            // salva log de erro
            Log::notice('Erro ao excluir o tipo de movimentação. [Err 1]', ['type_moviment_id' => $type_moviment->id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);
            return redirect()->route('type_moviments.index')->with('error', 'Erro ao excluir o tipo de movimentação. [Err 2]');
        }
    }

}
