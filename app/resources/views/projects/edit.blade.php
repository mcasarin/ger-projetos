@extends('layouts.admin')
@section('content')
    
    <h2>Editar Projeto</h2>
    <form action="{{ route('projects.update', ['project' => $project->id]) }}" method="POST">
        @csrf
        @method('PUT') <!-- Usando PUT para atualização -->
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
        </div>
        <div>
            <label for="name">Nome do Projeto:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $project->name) }}" required>
        </div>
        {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('name')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        <div>
            <label for="description">Descrição:</label>
            <textarea id="description" name="description" required>{{ old('description', $project->description) }}</textarea>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('description')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        
        <div>
            <label for="start_date">Data Inicial:</label>
            <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $project->start_date) }}" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('start_date')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="end_date">Data Final:</label>
            <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $project->end_date) }}" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('end_date')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="project_manager">Responsável pelo Projeto:</label>
            <input type="text" name="project_manager" value="{{ old('project_manager', $project->project_manager) }}" id="project_manager">
        </div>
        <div>
            <label for="initial_budget">Orçamento inicial</label>
            <input type="number" step="0.01" id="initial_budget" name="initial_budget" value="{{ old('initial_budget', $project->initial_budget) }}" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('initial_budget')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                @foreach($statusProj as $status)
                <option 
                    value="{{ $status->id }}" 
                    @selected(old('status', $project->status) == $status->id) {{-- Se o @selected estiver disponível --}}
                >
                    {{ $status->status }}
                </option>
            @endforeach
                    </select>
                    {{-- BLOCO DE ERRO POR CAMPO --}}
                    @error('status')
                        <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
                    @enderror
        </div>
        
        <button type="submit">Atualizar</button>
    </form>
@endsection

