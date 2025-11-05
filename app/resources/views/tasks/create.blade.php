@extends('layouts.admin')
@section('content')
    <h2>Cadastrar Tarefa</h2>
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        @method('POST')
        <div>
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="description">Descrição:</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        
        <div>
            <label for="start_date">Data Inicial:</label>
            <input type="datetime-local" id="start_date" name="start_date" required>
        </div>
        <div>
            <label for="due_date">Data Final:</label>
            <input type="datetime-local" id="due_date" name="due_date" required>
        </div>
        <div>
            <label for="owner_id">Responsável:</label>
            
            <select name="owner_id" id="owner_id">
                <option value="">Selecione</option>
                @foreach($listUsers as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="project_id">Projeto:</label>
            <select name="project_id" id="project_id" required>
                <option value="">Selecione</option>
                @foreach($listProjects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="">Selecione</option>
                @foreach($statusTasks as $status)
                    <option value="{{ $status->id }}">{{ $status->status }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">Cadastrar</button>
    </form>
@endsection
