@extends('layouts.admin')
@section('content')
    <h2>Cadastrar Movimento Financeiro</h2>
    <form action="{{ route('moviments.store') }}" method="POST">
        @csrf
        @method('POST')
        <div>
            <label for="project_id">Projeto:</label>
            <select name="project_id" id="project_id" required>
                <option value="">Selecione</option>
                @foreach($listProjects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('project_id')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="description">Descrição:</label>
            <textarea id="description" name="description" required></textarea>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('description')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="type">Tipo:</label>
            <select name="type" id="type" required>
                <option value="">Selecione</option>
                @foreach($listTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->type }}</option>
                @endforeach
            </select>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('type')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="amount">Valor:</label>
            <input type="number" step="0.01" id="amount" name="amount" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('amount')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="moviment_date">Data da Movimentação:</label>
            <input type="date" id="moviment_date" name="moviment_date" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('moviment_date')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        
        <button type="submit">Registrar</button>
    </form>
@endsection
