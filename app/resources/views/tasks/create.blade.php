@extends('layouts.admin')
@section('content')
    <!-- Título e Trilha de Navegação -->
    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Projeto</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('projects.index') }}" class="breadcrumb-link">Projetos</a>
                <span>/</span>
                <span>Projeto</span>
            </nav>
        </div>
    </div>
    <div class="content-box">
        <div class="content-box-header">
            <h3 class="content-box-title">Cadastrar</h3>
            <div class="content-box-btn">
                @can('index-tasks')
                    <a href="{{ route('tasks.index') }}"
                        class="btn-info align-icon-btn">
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

        <x-alert />

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        @method('POST')
        <div class="mb-4">
            <label for="title" class="form-label">Título:</label>
            <input type="text" class="form-input" id="title" name="title" required>
        </div>
        <div class="mb-4">
            <label for="description" class="form-label">Descrição:</label>
            <textarea class="form-input" id="description" name="description" required></textarea>
        </div>
        
        <div class="mb-4">
            <label for="start_date" class="form-label">Data Inicial:</label>
            <input type="datetime-local" class="form-input-date" id="start_date" name="start_date" required>
        </div>
        <div class="mb-4">
            <label for="due_date" class="form-label">Data Final:</label>
            <input type="datetime-local" class="form-input-date" id="due_date" name="due_date" required>
        </div>
        <div class="mb-4">
            <label for="owner_id" class="form-label-select">Responsável:</label>
            
            <select name="owner_id" id="owner_id" class="form-input-select">
                <option value="">Selecione</option>
                @foreach($listUsers as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="project_id" class="form-label-select">Projeto:</label>
            <select name="project_id" id="project_id" class="form-input-select" required>
                <option value="">Selecione</option>
                @foreach($listProjects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="status" class="form-label-select">Status:</label>
            <select id="status" name="status" class="form-input-select" required>
                <option value="">Selecione</option>
                @foreach($statusTasks as $status)
                    <option value="{{ $status->id }}">{{ $status->status }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <button type="submit" class="btn-success align-icon-btn">
                <!-- Ícone plus-circle (Heroicons) -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>Cadastrar</span>
            </button>
        </div>
    </form>
    </div>
@endsection
