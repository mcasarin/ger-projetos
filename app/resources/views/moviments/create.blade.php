@extends('layouts.admin')

@section('content')
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
    
    <div class="content-box">
        <div class="content-box-header">
            <h3 class="content-box-title">Cadastrar</h3>
            <div class="content-box-btn">
                @can('index-moviments')
                    <a href="{{ route('moviments.index') }}" class="btn-info align-icon-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
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
                        <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
                @error('project_id')
                    <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">Descrição:</label>
                <textarea class="form-input" id="description" name="description">{{ old('description') }}</textarea>
                @error('description')
                    <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="type" class="form-label-select">Tipo:</label>
                    <select class="form-input-select" name="type" id="type" required>
                        <option value="">Selecione</option>
                        @foreach($listTypes as $type)
                            <option value="{{ $type->id }}" {{ old('type') == $type->id ? 'selected' : '' }}>
                                {{ $type->type }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex-1">
                    <label for="rubric" class="form-label-select">Rubrica:</label>
                    <select class="form-input-select" name="rubric" id="rubric" required>
                        <option value="">Selecione</option>
                        @foreach($listRubrics as $rubric)
                            <option value="{{ $rubric->id }}" {{ old('rubric') == $rubric->id ? 'selected' : '' }}>
                                {{ $rubric->rubric }}
                            </option>
                        @endforeach
                    </select>
                    @error('rubric')
                        <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="amount" class="form-label">Valor:</label>
                <input type="number" class="form-input" step="0.01" id="amount" name="amount" value="{{ old('amount') }}" required>
                @error('amount')
                    <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
                @enderror
            </div>

            {{-- NOVO: Seção Beneficiário --}}
            <div class="mb-4">
                <div class="card">
                    <div class="card-header">
                        <label style="font-weight: bold; margin: 0;">Dados do Beneficiário</label>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="beneficiary_name" class="form-label">Nome do Beneficiário *</label>
                                <input type="text" 
                                       name="beneficiary_name" 
                                       id="beneficiary_name"
                                       class="form-input"
                                       value="{{ old('beneficiary_name') }}"
                                       required
                                       list="beneficiary-list"
                                       placeholder="Digite o nome ou selecione da lista">
                                <datalist id="beneficiary-list">
                                    @foreach($listBeneficiaries ?? [] as $benef)
                                        <option value="{{ $benef->name }}" 
                                                data-document="{{ $benef->document }}"
                                                data-id="{{ $benef->id }}">
                                    @endforeach
                                </datalist>
                                @error('beneficiary_name')
                                    <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="beneficiary_document" class="form-label">CPF/CNPJ *</label>
                                <input type="text" 
                                       name="beneficiary_document"
                                       id="beneficiary_document"
                                       class="form-input"
                                       value="{{ old('beneficiary_document') }}"
                                       required
                                       placeholder="000.000.000-00 ou 00.000.000/0000-00"
                                       maxlength="18">
                                @error('beneficiary_document')
                                    <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label for="moviment_date" class="form-label">Data da Movimentação:</label>
                <input type="date" class="form-input-date" id="moviment_date" name="moviment_date" value="{{ old('moviment_date') }}" required>
                @error('moviment_date')
                    <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <button type="submit" class="btn-success align-icon-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>Registrar</span>
                </button>
            </div>
        </form>
    </div>

    <script>
        // Máscara para CPF/CNPJ
        document.getElementById('beneficiary_document').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            let formatted = '';
            
            if (value.length <= 11) {
                // CPF
                formatted = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            } else {
                // CNPJ
                formatted = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
            }
            
            e.target.value = formatted.slice(0, 18);
        });

        // Auto-preenche nome quando seleciona da lista
        document.getElementById('beneficiary_name').addEventListener('input', function(e) {
            const option = Array.from(e.target.list.options).find(opt => 
                opt.value.toLowerCase() === e.target.value.toLowerCase()
            );
            
            if (option) {
                document.getElementById('beneficiary_document').value = option.dataset.document;
            }
        });
    </script>
</div>
@endsection