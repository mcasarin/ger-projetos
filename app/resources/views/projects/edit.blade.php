@extends('layouts.admin')
@section('content')
    <!-- Título e Trilha de Navegação -->
    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Projeto</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <span>...</span>
                <span>/</span>
                <a href="{{ route('projects.index') }}"
                    class="breadcrumb-link">Projetos</a>
                <span>/</span>
                <span>Projeto</span>
            </nav>
        </div>
    </div>
    <div class="content-box">
        <div class="content-box-header">
            <h3 class="content-box-title">Editar Projeto</h3>
            <div class="content-box-btn">
                @can('index-projects')
                    <a href="{{ route('projects.index') }}" class="btn-info align-icon-btn">
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

    <form action="{{ route('projects.update', ['project' => $project->id]) }}" method="POST">
        @csrf
        @method('PUT') <!-- Usando PUT para atualização -->
        <div class="mb-4">
        <label for="parent_id" class="form-label-select">Projeto Pai (Opcional):</label>
            <select name="parent_id" id="parent_id" class="form-input-select">
                
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
        <div class="mb-4">
            <label for="name" class="form-label">Nome do Projeto:</label>
            <input type="text" class="form-input" id="name" name="name" value="{{ old('name', $project->name) }}" required>
        </div>
        {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('name')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        <div class="mb-4">
            <label for="description" class="form-label">Descrição:</label>
            <textarea class="form-input" id="description" name="description" required>{{ old('description', $project->description) }}</textarea>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('description')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="start_date" class="form-label">Data Inicial:</label>
            <input type="date" class="form-input-date" id="start_date" name="start_date" value="{{ old('start_date', $project->start_date) }}" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('start_date')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="end_date" class="form-label">Data Final:</label>
            <input type="date" class="form-input-date" id="end_date" name="end_date" value="{{ old('end_date', $project->end_date) }}" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('end_date')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="project_manager" class="form-label">Responsável pelo Projeto:</label>
            <input type="text" class="form-input" name="project_manager" value="{{ old('project_manager', $project->project_manager) }}" id="project_manager">
        </div>
        <div class="mb-4">
            <label for="initial_budget" class="form-label">Orçamento inicial</label>
            <input type="number" class="form-input" step="0.01" id="initial_budget" name="initial_budget" value="{{ old('initial_budget', $project->initial_budget) }}" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('initial_budget')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="status" class="form-label-select">Status:</label>
            <select class="form-input-select"id="status" name="status" required>
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
