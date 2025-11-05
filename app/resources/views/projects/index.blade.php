@extends('layouts.admin')
@section('content')
    <h2>Lista de Projetos</h2>
    <x-alert />

    <a href="{{ route('projects.create') }}">Cadastrar Projeto</a>
    <a href="{{ route('status_projs.index') }}">Listar Status de Projetos</a>
    <a href="{{ route('tasks.index') }}">Listar Tarefas</a>
    <a href="{{ route('moviments.index') }}">Listar Movimentações</a>

    @forelse ($projects as $project)
        <p>
            <strong>ID:</strong> {{ $project->id }}<br>
            <strong>Nome:</strong> {{ $project->name }}<br>
            <strong>Descrição:</strong> {{ $project->description }}<br>
            <strong>Data de Início:</strong> {{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }}<br>
            <strong>Data de Término:</strong> {{ \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') }}<br>
            <strong>Gerente do Projeto:</strong> {{ $project->project_manager }}<br>
            <strong>Status:</strong> {{ $project->statusRel->status ?? 'Não definido' }}<br>
            <a href="{{ route('projects.show', ['project' => $project->id]) }}">Detalhes</a><br>
            <a href="{{ route('projects.edit', ['project' => $project->id]) }}">Editar</a><br>
            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este projeto?')">Excluir</button>
            </form>
        </p>
        <hr>
    @empty
        <p>Nenhum projeto encontrado.</p>
    @endforelse

    {{ $projects->links() }}
@endsection
