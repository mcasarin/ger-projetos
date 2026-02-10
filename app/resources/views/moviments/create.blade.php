@extends('layouts.admin')
@section('content')
    <!-- Título e Trilha de Navegação -->
    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Movimentação Financeira</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('moviments.index') }}" class="breadcrumb-link">Movimentos</a>
                <span>/</span>
                <span>Cadastro Movimento</span>
            </nav>
        </div>
    </div>
    <div class="content-box">
        <div class="content-box-header">
            <h3 class="content-box-title">Cadastrar</h3>
            <div class="content-box-btn">
                @can('index-moviments')
                    <a href="{{ route('moviments.index') }}"
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


    <form action="{{ route('moviments.store') }}" method="POST">
        @csrf
        @method('POST')
        <div class="mb-4">
            <label for="project_id" class="form-label-select">Projeto:</label>
            <select class="form-input-select" name="project_id" id="project_id" required>
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
        <div class="mb-4">
            <label for="description" class="form-label">Descrição:</label>
            <textarea class="form-input" id="description" name="description" required></textarea>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('description')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="type" class="form-label-select">Tipo:</label>
            <select class="form-input-select" name="type" id="type" required>
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
        <div class="mb-4">
            <label for="amount" class="form-label">Valor:</label>
            <input type="number" class="form-input" step="0.01" id="amount" name="amount" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('amount')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="moviment_date" class="form-label">Data da Movimentação:</label>
            <input type="date" class="form-input-date" id="moviment_date" name="moviment_date" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('moviment_date')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-4">
            <button type="submit" class="btn-success align-icon-btn">
                <!-- Ícone plus-circle (Heroicons) -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>Registrar</span>
            </button>
        </div>
    </form>
@endsection
