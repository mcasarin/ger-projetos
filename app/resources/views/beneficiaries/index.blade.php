@extends('layouts.admin')
@section('content')
<!-- Título e Trilha de Navegação - breadcrumbs -->
    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Beneficiários</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('beneficiaries.index') }}" class="breadcrumb-link">Movimentação</a>
                <span>/</span>
                <span>Beneficiários</span>
            </nav>
        </div>
    </div>
        <div class="content-box">
        <div class="content-box-header">
            <h3 class="content-box-title">Listagem de Beneficiários</h3>
            @can('index-moviments')
            <div class="content-box-btn">
                <a href="{{ route('moviments.index') }}" class="btn-success flex items-center space-x-1">
                    <!-- Ícone arrow-long-left (Heroicons) -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                    </svg>

                    <span>Voltar para Movimentações</span>
                </a>
            </div>
            @endcan
            @can('create-moviments')
            <div class="content-box-btn">
                <a href="{{ route('moviments.create') }}" class="btn-success flex items-center space-x-1">
                    <!-- Ícone plus-circle (Heroicons) -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>Cadastrar Movimentação</span>
                </a>
            </div>
            @endcan
            @can('create-beneficiaries')
            <div class="content-box-btn">
                <a href="{{ route('beneficiaries.create') }}" class="btn-success flex items-center space-x-1">
                    <!-- Ícone plus-circle (Heroicons) -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>Cadastrar novo Beneficiário</span>
                </a>
            </div>
            @endcan
        </div>
    <x-alert />
    <div class="table-container mt-6">
                    <table class="table">
                        <thead>
                            <tr class="table-row-header">
                                <th class="table-header">ID</th>
                                <th class="table-header">Nome</th>
                                <th class="table-header center">Documento</th>
                                <th class="table-header center">Tipo</th>
                                <th class="table-header center">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
    @forelse ($beneficiaries as $beneficiary)
        <tr class="table-row-body">
            <td class="table-body">{{ $beneficiary->id }}</td>
            <td class="table-body">{{ $beneficiary->name }}</td>
            <td class="table-body">{{ $beneficiary->anonymized_document }}</td>
            <td class="table-body">{{ $beneficiary->document_type }}</td>
            
        @can('show-beneficiaries')
                <td class="table-body table-actions">
                        <a href="{{ route('beneficiaries.show', ['beneficiary' => $beneficiary->id]) }}" class="btn-primary hidden md:flex items-center space-x-1">
                            <!-- Ícone eye (Heroicons) -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <span>Detalhes</span>
                                </a>
                            @endcan
                            @can('edit-beneficiaries')
                            <a href="{{ route('beneficiaries.edit', ['beneficiary' => $beneficiary->id]) }}"
                                        class="btn-warning hidden md:flex items-center space-x-1">
                                        <!-- Ícone pencil-square (Heroicons) -->
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                        <span>Editar</span>
                                    </a>
                                    @endcan
                                    @can('destroy-beneficiaries')
                                    <form id="delete-form-{{ $beneficiary->id }}" action="{{ route('beneficiaries.destroy', $beneficiary->id) }}" method="POST">
                                        @csrf
                                        @method('delete')

                                        <button type="button" class="btn-danger hidden md:flex items-center space-x-1" onclick="confirmDelete({{ $beneficiary->id }})">
                                        <!-- Ícone trash (Heroicons) -->
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg><span>Apagar</span></button>

                                    </form>

                                    @endcan
                                </td>
                            </tr>
    @empty
        <p>Nenhum tipo de movimento encontrado.</p>
    @endforelse
@endsection

