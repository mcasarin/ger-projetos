@extends('layouts.admin')
@section('content')
    
    <h2>Editar Projeto</h2>
    <form action="{{ route('projects.update', ['project' => $project->id]) }}" method="POST">
        @csrf
        @method('PUT') <!-- Usando PUT para atualização -->
        
        <div>
            <label for="name">Nome do Projeto:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $project->name) }}" required>
        </div>
        <div>
            <label for="description">Descrição:</label>
            <textarea id="description" name="description" required>{{ old('description', $project->description) }}</textarea>
        </div>
        
        <div>
            <label for="start_date">Data Inicial:</label>
            <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $project->start_date) }}" required>
        </div>
        <div>
            <label for="end_date">Data Final:</label>
            <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $project->end_date) }}" required>
        </div>
        <div>
            <label for="project_manager">Responsável pelo Projeto:</label>
            <input type="text" name="project_manager" value="{{ old('project_manager', $project->project_manager) }}" id="project_manager">
        </div>
        <div>
            <label for="initial_budget">Orçamento inicial</label>
            <input type="number" step="0.01" id="initial_budget" name="initial_budget" value="{{ old('initial_budget', $project->initial_budget) }}" required>
        </div>
        <button type="submit">Atualizar</button>
    </form>
@endsection

