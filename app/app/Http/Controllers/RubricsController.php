<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rubric;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class RubricsController extends Controller
{
    public function index() {
        // Recuperar registros do banco de dados
        $rubric = Rubric::orderBy('id', 'asc')->get();
        Log::info('Lista de rubricas acessada.');
        //Carregar a view
        return view('rubrics.index',['menu' => 'moviments', 'rubrics' => $rubric]);
    }
    // Detalhes da rubrica
    public function show(Rubric $rubric) {
        // Salva log
        Log::info('Detalhes da rubrica acessados.', ['rubric_id' => $rubric->id, 'user_id' => Auth::id()]);
        // Carregar a view com os detalhes do projeto
        return view('rubrics.show', ['menu' => 'moviments', 'rubric' => $rubric]);
    }
    
    public function create() {
        //Caregar a view
        return view('rubrics.create', ['menu' => 'moviments']);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'rubric' => 'required|string|max:255|unique:rubrics,rubric',
        ], [
            'rubric.unique' => 'Esta rubrica já está cadastrada.',
            'rubric.required' => 'O campo rubrica é obrigatório.',
        ]);

        Log::info('Dados validados com sucesso para nova rubrica.', $validatedData);

        try {
            $rubric = Rubric::create([
                'rubric' => $validatedData['rubric']
            ]);

            Log::info('Nova rubrica cadastrada.', [
                'rubric_id' => $rubric->id, 
                'user_id' => Auth::id()
            ]);
            
            return redirect()->route('rubrics.show', ['rubric' => $rubric->id])
                            ->with('success', 'Rubrica cadastrada com sucesso!');

        } catch (Exception $e) {
            Log::error('Erro ao cadastrar nova rubrica.', [
                'error' => $e->getMessage(), 
                'user_id' => Auth::id()
            ]);

            return back()->withInput()->with('error', 'Erro interno ao processar cadastro.');
        }
    }

    public function edit(Rubric $rubric) {
        return view('rubrics.edit', [
            'menu' => 'moviments',
            'rubric' => $rubric
        ]);
    }

    public function update(Request $request, Rubric $rubric) {
        $validatedData = $request->validate([
            'rubric' => 'required|string|max:255|unique:rubrics,rubric,' . $rubric->id,
        ], [
            'rubric.unique' => 'Esta rubrica já está cadastrada.',
            'rubric.required' => 'O campo rubrica é obrigatório.',
        ]);

        Log::info('Dados validados com sucesso para atualização da rubrica.', [
            'rubric_id' => $rubric->id,
            'validated_data' => $validatedData
        ]);

        try {
            $rubric->update([
                'rubric' => $validatedData['rubric']
            ]);

            Log::info('Rubrica atualizada com sucesso.', [
                'rubric_id' => $rubric->id, 
                'user_id' => Auth::id()
            ]);

            return redirect()->route('rubrics.show', ['rubric' => $rubric->id])
                            ->with('success', 'Rubrica atualizada com sucesso!');

        } catch (Exception $e) {
            Log::error('Erro ao atualizar rubrica.', [
                'error' => $e->getMessage(), 
                'rubric_id' => $rubric->id, 
                'user_id' => Auth::id()
            ]);

            return back()->withInput()->with('error', 'Erro interno ao processar atualização.');
        }
    }
        public function destroy(Rubric $rubric) {
        try {
            $rubric->delete();
            // salva log
            Log::info('Rubrica excluída.', ['rubric_id' => $rubric->id, 'user_id' => Auth::id()]);
            return redirect()->route('rubrics.index')->with('success', 'Rubrica excluída com sucesso!');
            
        } catch (Exception $e) {
            // salva log de erro
            Log::notice('Erro ao excluir a rubrica. [Err 1]', ['rubric_id' => $rubric->id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);
            return redirect()->route('rubrics.index')->with('error', 'Erro ao excluir a rubrica. [Err 2]');
        }
    }
}
