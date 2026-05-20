<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beneficiary;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class BeneficiariesController extends Controller
{
    public function index() {
        // Recuperar registros do banco de dados
        $beneficiaries = Beneficiary::orderBy('id', 'asc')->get();
        Log::info('Lista de beneficiários acessada.');
        //Carregar a view
        return view('beneficiaries.index',['menu' => 'beneficiaries','beneficiaries' => $beneficiaries]);
    }
    // Detalhes da tipo de movimento
    public function show(Beneficiary $beneficiary) {
        // Salva log
        Log::info('Detalhes do beneficiário acessados.', ['beneficiary_id' => $beneficiary->id, 'user_id' => Auth::id()]);
        // Carregar a view com os detalhes do projeto
        return view('beneficiaries.show', ['menu' => 'beneficiaries', 'beneficiary' => $beneficiary]);
    }
    // Formulário para criar uma nova tipo de movimento
    public function create() {
        return view('beneficiaries.create', ['menu' => 'beneficiaries']);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'document' => 'required|string|max:255|unique:beneficiaries,document',
        ], [
            'document.unique' => 'Este documento já está cadastrado.',
            'document.required' => 'O campo documento é obrigatório.',
        ]);

        Log::info('Dados validados com sucesso para novo beneficiário.', $validatedData);

        try {
            $beneficiary = Beneficiary::create([
                'document' => $validatedData['document']
            ]);

            Log::info('Novo beneficiário cadastrado.', [
                'beneficiary_id' => $beneficiary->id,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('beneficiaries.show', ['beneficiary' => $beneficiary->id])
                            ->with('success', 'Beneficiário cadastrado com sucesso!');

        } catch (Exception $e) {
            Log::error('Erro ao cadastrar novo beneficiário.', [
                'error' => $e->getMessage(), 
                'user_id' => Auth::id()
            ]);

            return back()->withInput()->with('error', 'Erro interno ao processar cadastro.');
        }
    }

    public function edit(Beneficiary $beneficiary) {
        return view('beneficiaries.edit', [
            'menu' => 'beneficiaries',
            'beneficiary' => $beneficiary
        ]);
    }

    public function update(Request $request, Beneficiary $beneficiary) {
        $validatedData = $request->validate([
            'document' => 'required|string|max:255|unique:beneficiaries,document,' . $beneficiary->id,
        ], [
            'document.unique' => 'Este documento já está cadastrado.',
            'document.required' => 'O campo documento é obrigatório.',
        ]);

        Log::info('Dados validados com sucesso para atualização do beneficiário.', [
            'beneficiary_id' => $beneficiary->id,
            'validated_data' => $validatedData
        ]);

        try {
            $beneficiary->update([
                'document' => $validatedData['document']
            ]);

            Log::info('Beneficiário atualizado com sucesso.', [
                'beneficiary_id' => $beneficiary->id, 
                'user_id' => Auth::id()
            ]);

            return redirect()->route('beneficiaries.show', ['beneficiary' => $beneficiary->id])
                            ->with('success', 'Beneficiário atualizado com sucesso!');

        } catch (Exception $e) {
            Log::error('Erro ao atualizar beneficiário.', [
                'error' => $e->getMessage(), 
                'beneficiary_id' => $beneficiary->id, 
                'user_id' => Auth::id()
            ]);

            return back()->withInput()->with('error', 'Erro interno ao processar atualização.');
        }
    }
        public function destroy(Beneficiary $beneficiary) {
        try {
            $beneficiary->delete();
            // salva log
            Log::info('Beneficiário excluído.', ['beneficiary_id' => $beneficiary->id, 'user_id' => Auth::id()]);
            return redirect()->route('beneficiaries.index')->with('success', 'Beneficiário excluído com sucesso!');
            
        } catch (Exception $e) {
            // salva log de erro
            Log::notice('Erro ao excluir o beneficiário. [Err 1]', ['beneficiary_id' => $beneficiary->id, 'error' => $e->getMessage(), 'user_id' => Auth::id()]);
            return redirect()->route('beneficiaries.index')->with('error', 'Erro ao excluir o beneficiário. [Err 2]');
        }
    }

}
