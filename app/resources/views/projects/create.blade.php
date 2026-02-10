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
                @can('index-projects')
                    <a href="{{ route('projects.index') }}"
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

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        @method('POST')
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
            
            @error('parent_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="name" class="form-label">Nome do Projeto:</label>
            <input type="text" class="form-input" id="name" name="name" required>
        </div>
        <div class="mb-4">
            <label for="description" class="form-label">Descrição:</label>
            <textarea id="description" class="form-input" name="description" required></textarea>
        </div>
        
        <div class="mb-4">
            <label for="start_date" class="form-label">Data Inicial:</label>
            <input type="date" class="form-input-date" id="start_date" name="start_date" required>
        </div>
        <div class="mb-4">
            <label for="end_date" class="form-label">Data Final:</label>
            <input type="date" class="form-input-date" id="end_date" name="end_date" required>
        </div>
        <div class="mb-4">
            <label for="project_manager" class="form-label">Responsável pelo Projeto:</label>
            <input type="text" class="form-input" name="project_manager" id="project_manager">
        </div>
        <div class="mb-4">
            <label for="initial_budget" class="form-label">Orçamento inicial</label>
            <input type="number" class="form-input" step="0.01" id="initial_budget" name="initial_budget" required>
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
