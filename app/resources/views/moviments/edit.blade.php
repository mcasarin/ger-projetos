@extends('layouts.admin')
@section('content')
    
    <h2>Editar Movimentação Financeira</h2>
    <form action="{{ route('moviments.update', ['moviment' => $moviment->id]) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div>
            <label for="description">Descrição:</label>
            <textarea id="description" name="description" required>{{ old('description', $moviment->description) }}</textarea>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('description')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        
        <div>
            <label for="amount">Valor:</label>
            <input type="number" id="amount" name="amount" value="{{ old('amount', $moviment->amount) }}" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('amount')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="moviment_date">Data Final:</label>
            <input type="date" id="moviment_date" name="moviment_date" value="{{ old('moviment_date', $moviment->moviment_date) }}" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('moviment_date')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="type">Tipo:</label>
            <select name="type" id="type">
                @foreach($listTypes as $type)
        <option 
            value="{{ $type->id }}" 
            
            {{-- Usa @selected para preselecionar o usuário salvo na tarefa. --}}
            {{-- Compara o valor salvo na coluna 'type' da tarefa com o ID do usuário atual. --}}
            @selected(old('type', $moviment->type) == $type->id)
        >
            {{ $type->type }}
        </option>
    @endforeach
            </select>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('type')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="project_id">Projeto:</label>
            <select name="project_id" id="project_id" required>
                @foreach($listProjects as $project)
        <option 
            value="{{ $project->id }}" 
            
            {{-- Usa @selected para comparar o valor salvo na tarefa com o ID do projeto atual --}}
            {{-- old('project_id', $moviment->project_id) pega o valor salvo ou o valor da sessão após erro de validação --}}
            @selected(old('project_id', $moviment->project_id) == $project->id)
        >
            {{ $project->name }}
        </option>
    @endforeach
            </select>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('project_id')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        
        <button type="submit">Atualizar</button>
    </form>
@endsection

