@extends('layouts.admin')
@section('content')
    <h2>Lista de Movimentações Financeiras</h2>
    <x-alert />

    <a href="{{ route('moviments.create') }}">Cadastrar Movimento</a>
    <a href="{{ route('type_moviment.index') }}">Listar Tipos de Movimentação</a>
    

    @forelse ($moviments as $moviment)
        <p>
            <strong>ID:</strong> {{ $moviment->id }}<br>
            <strong>Nome:</strong> {{ $moviment->name }}<br>
            <strong>Descrição:</strong> {{ $moviment->description }}<br>
            <strong>Data de Início:</strong> {{ \Carbon\Carbon::parse($moviment->start_date)->format('d/m/Y') }}<br>
            <strong>Data de Término:</strong> {{ \Carbon\Carbon::parse($moviment->end_date)->format('d/m/Y') }}<br>
            <strong>Gerente do Projeto:</strong> {{ $moviment->moviment_manager }}<br>
            <strong>Status:</strong> {{ $moviment->statusRel->status ?? 'Não definido' }}<br>
            <a href="{{ route('moviments.show', ['moviment' => $moviment->id]) }}">Detalhes</a><br>
            <a href="{{ route('moviments.edit', ['moviment' => $moviment->id]) }}">Editar</a><br>
            <form action="{{ route('moviments.destroy', $task->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este registro?')">Excluir</button>
            </form>
        </p>
        <hr>
    @empty
        <p>Nenhuma movimentação encontrada.</p>
    @endforelse

    {{ $projects->links() }}
@endsection
