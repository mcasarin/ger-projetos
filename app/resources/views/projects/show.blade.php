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
            <h3 class="content-box-title">Detalhes</h3>
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

                @can('edit-projects')
                    <a href="{{ route('projects.edit', ['project' => $project->id]) }}" class="btn-warning align-icon-btn">
                        <!-- Ícone pencil-square (Heroicons) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        <span>Editar</span>
                    </a>
                @endcan

                @can('destroy-project')
                    <form id="delete-form-{{ $project->id }}" action="{{ route('projects.destroy', ['project' => $project->id]) }}" method="POST">
                        @csrf
                        @method('delete')

                        <button type="button" onclick="confirmDelete({{ $project->id }})" class="btn-danger flex items-center space-x-1">
                            <!-- Ícone trash (Heroicons) -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            <span>Apagar</span>
                        </button>

                    </form>
                @endcan
            </div>
        </div>
    <x-alert />

        <div class="detail-box">

            <div class="mb-1">
                <span class="title-detail-content">ID: </span>
                <span class="detail-content">{{ $project->id }}</span>
            </div>

            <div class="mb-1">
                <span class="title-detail-content">Nome: </span>
                <span class="detail-content">{{ $project->name }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Descrição:</span>
                <span class="detail-content">{{ $project->description }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Orçamento Inicial:</span>
                <span class="detail-content">R$ {{ $project->initial_budget }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Data de Início:</span>
                <span class="detail-content">{{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Data de Término:</span>
                <span class="detail-content">{{ \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Gerente do Projeto:</span>
                <span class="detail-content">{{ $project->project_manager }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Status:</span>
                <span class="detail-content">{{ $project->statusRel->status ?? 'Não definido' }}</span>
            </div>
            <div class="mb-1"> 
                <span class="title-detail-content">Projeto Pai:</span>
                <span class="detail-content">
                    @if ($project->parent)
                        {{ $project->parent->name }} 
                        (<a href="{{ route('projects.show', $project->parent) }}">Ver Detalhes</a>)
                    @else
                        N/A
                    @endif
                </span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Criado por:</span>
                <span class="detail-content">{{ $project->owner->name }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Criado em:</span>
                <span class="detail-content">{{ \Carbon\Carbon::parse($project->created_at)->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Atualizado em:</span>
                <span class="detail-content">{{ \Carbon\Carbon::parse($project->updated_at)->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>
        <div>
            <div class="content-box mt-4">
                <div class="content-box-header">
                    <h3 class="content-box-title">Tarefas do Projeto</h3>
                    <div class="content-box-btn">
                        @can('create-tasks')
                            <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="btn-success align-icon-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span>Nova Tarefa</span>
                            </a>
                        @endcan
                    </div>
                </div>
                @if ($project->tasks->count() > 0)
                    <div class="table-container mt-6">
                        <table class="table">
                            <thead>
                                <tr class="table-row-header">
                                    <th class="table-header">ID</th>
                                    <th class="table-header">Título</th>
                                    <th class="table-header">Descrição</th>
                                    <th class="table-header">Status</th>
                                    <th class="table-header center">Data Início</th>
                                    <th class="table-header center">Data Término</th>
                                    <th class="table-header">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project->tasks->sortBy('start_date') as $task)
                                    <tr class="table-row-body">
                                        <td class="table-body">{{ $task->id }}</td>
                                        <td class="table-body">{{ $task->title }}</td>
                                        <td class="table-body">{{ Str::limit($task->description, 50) }}</td>
                                        <td class="table-body">{{ $task->statusRelTask->status ?? 'Não definido' }}</td>
                                        <td class="table-body center">{{ \Carbon\Carbon::parse($task->start_date)->format('d/m/Y') }}</td>
                                        <td class="table-body center">{{ \Carbon\Carbon::parse($task->end_date)->format('d/m/Y') }}</td>
                                        <td class="table-body">
                                            <a href="{{ route('tasks.show', ['task' => $task->id, 'redirect' => request()->fullUrl()]) }}" class="btn-info btn-sm">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-gray-500 py-4">Nenhuma tarefa encontrada para este projeto.</div>
                @endif
            </div>
            <div class="content-box mt-4">
                <div class="content-box-header">
                    <h3 class="content-box-title">Movimentos Financeiros do Projeto</h3>
                    <div class="content-box-btn">
                        @can('create-moviments')
                            <a href="{{ route('moviments.create', ['project_id' => $project->id]) }}" class="btn-success align-icon-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span>Novo Movimento</span>
                            </a>
                        @endcan
                    </div>
                </div>
                @if ($project->Movimentacao->count() > 0)
                    <div class="table-container mt-6">
                        <table class="table">
                            <thead>
                                <tr class="table-row-header">
                                    <th class="table-header">ID</th>
                                    
                                    <th class="table-header">Descrição</th>
                                    <th class="table-header">Tipo</th>
                                    <th class="table-header">Valor</th>
                                    <th class="table-header center">Data</th>
                                    
                                    <th class="table-header">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project->Movimentacao->sortBy('start_date') as $moviment)
                                    <tr class="table-row-body">
                                        <td class="table-body">{{ $moviment->id }}</td>
                                        <td class="table-body">{{ Str::limit($moviment->description, 50) }}</td>
                                        <td class="table-body">{{ $moviment->TypeMoviment->type ?? 'Não definido' }}</td>
                                        <td class="table-body">R$ {{ number_format($moviment->amount, 2, ',', '.') }}</td>
                                        <td class="table-body center">{{ \Carbon\Carbon::parse($moviment->created_at)->format('d/m/Y') }}</td>
                                        <td class="table-body">
                                            <a href="{{ route('moviments.show', ['moviment' => $moviment->id, 'redirect' => request()->fullUrl()]) }}" class="btn-info btn-sm">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-gray-500 py-4">Nenhuma movimentação encontrada para este projeto.</div>
                @endif
            </div>
        </div>
     </div>
@endsection

