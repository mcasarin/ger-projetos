@extends('layouts.admin')
@section('content')
    
    <h2>Editar Tarefa</h2>
    <form action="{{ route('tasks.update', ['task' => $task->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('title')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        </div>
        <div>
            <label for="description">Descrição:</label>
            <textarea id="description" name="description" required>{{ old('description', $task->description) }}</textarea>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('description')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        
        <div>
            <label for="start_date">Data Inicial:</label>
            <input type="datetime-local" id="start_date" name="start_date" value="{{ old('start_date', $task->start_date) }}" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('start_date')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="due_date">Data Final:</label>
            <input type="datetime-local" id="due_date" name="due_date" value="{{ old('due_date', $task->due_date) }}" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('due_date')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="owner_id">Responsável:</label>
            
            <select name="owner_id" id="owner_id">
                @foreach($listUsers as $user)
        <option 
            value="{{ $user->id }}" 
            
            {{-- Usa @selected para preselecionar o usuário salvo na tarefa. --}}
            {{-- Compara o valor salvo na coluna 'owner_id' da tarefa com o ID do usuário atual. --}}
            @selected(old('owner_id', $task->owner_id) == $user->id)
        >
            {{ $user->name }}
        </option>
    @endforeach
            </select>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('owner_id')
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
            {{-- old('project_id', $task->project_id) pega o valor salvo ou o valor da sessão após erro de validação --}}
            @selected(old('project_id', $task->project_id) == $project->id)
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
        <div>
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                @foreach($statusTasks as $status)
        <option 
            value="{{ $status->id }}" 
            @selected(old('status', $task->status) == $status->id) {{-- Se o @selected estiver disponível --}}
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

