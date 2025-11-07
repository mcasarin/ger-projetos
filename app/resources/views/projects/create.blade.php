@extends('layouts.admin')
@section('content')
    <h2>Cadastrar Projeto</h2>
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        @method('POST')
        <div>
        <label for="parent_id">Projeto Pai (Opcional):</label>
            <select name="parent_id" id="parent_id" class="form-control">
                
                {{-- Opção Padrão: Sem Pai (Projeto Raiz) --}}
                <option value="">-- Nenhum Pai (Projeto Raiz) --</option> 
                
                @foreach($listProjects as $parentOption)
                    <option 
                        value="{{ $parentOption->id }}"
                        
                        {{-- Lógica de Preseleção para Edição: --}}
                        {{-- Compara o valor salvo (ou o valor de old()) com o ID do projeto atual no loop --}}
                        @selected(old('parent_id', $project->parent_id ?? null) == $parentOption->id)
                    >
                        {{ $parentOption->name }}
                    </option>
                @endforeach
            </select>
            
            @error('parent_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="name">Nome do Projeto:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="description">Descrição:</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        
        <div>
            <label for="start_date">Data Inicial:</label>
            <input type="date" id="start_date" name="start_date" required>
        </div>
        <div>
            <label for="end_date">Data Final:</label>
            <input type="date" id="end_date" name="end_date" required>
        </div>
        <div>
            <label for="project_manager">Responsável pelo Projeto:</label>
            <input type="text" name="project_manager" id="project_manager">
        </div>
        <div>
            <label for="initial_budget">Orçamento inicial</label>
            <input type="number" step="0.01" id="initial_budget" name="initial_budget" required>
        </div>
        <button type="submit">Cadastrar</button>
    </form>
@endsection
