@extends('layouts.admin')
@section('content')
 <!-- Título e Trilha de Navegação -->
    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Tarefas</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <span>...</span>
                <span>/</span>
                <a href="{{ route('moviments.index') }}"
                    class="breadcrumb-link">Tarefas</a>
                <span>/</span>
                <span>Tarefa</span>
            </nav>
        </div>
    </div>
    <div class="content-box">
        <div class="content-box-header">
            <h3 class="content-box-title">Editar Tarefa</h3>
            <div class="content-box-btn">
                @can('index-tasks')
                    <a href="{{ route('tasks.index') }}" class="btn-info align-icon-btn">
                        <!-- Ícone queue-list (Heroicons) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                        </svg>
                        <span>Listar</span>
                    </a>
                @endcan
            </div>
        </div>
    
    <form action="{{ route('tasks.update', ['task' => $task->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
        <label for="title" class="form-label">Título:</label>
            <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('title')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="description" class="form-label">Descrição:</label>
            <textarea class="form-input" id="description" name="description" required>{{ old('description', $task->description) }}</textarea>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('description')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="start_date" class="form-label">Data Inicial:</label>
            <input type="datetime-local" class="form-input-date" id="start_date" name="start_date" value="{{ old('start_date', $task->start_date) }}" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('start_date')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="due_date" class="form-label">Data Final:</label>
            <input type="datetime-local" class="form-input-date" id="due_date" name="due_date" value="{{ old('due_date', $task->due_date) }}" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('due_date')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="owner_id" class="form-label-select">Responsável:</label>
            
            <select class="form-input-select" name="owner_id" id="owner_id">
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
        <div class="mb-4">
            <label for="project_id" class="form-label-select">Projeto:</label>
            <select class="form-input-select" name="project_id" id="project_id" required>
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
        <div class="mb-4">
            <label for="status" class="form-label-select">Status:</label>
            <select class="form-input-select" id="status" name="status" required>
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
        <button type="submit" class="btn-warning align-icon-btn">
                <!-- Ícone pencil-square (Heroicons) -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                <span>Atualizar</span>
            </button>
    </form>
    </div>
@endsection

