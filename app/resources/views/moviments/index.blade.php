@extends('layouts.admin')
@section('content')
    <h2>Lista de Movimentações Financeiras</h2>
    <x-alert />

    <a href="{{ route('moviments.create') }}">Cadastrar Movimento</a>
    <a href="{{ route('type_moviments.index') }}">Listar Tipos de Movimentação</a>
    

    @forelse ($moviments as $moviment)
        <p>
            <strong>ID:</strong> {{ $moviment->id }}<br>
            <strong>Descrição:</strong> {{ $moviment->description }}<br>
            <strong>Data de Início:</strong> {{ \Carbon\Carbon::parse($moviment->date_moviment)->format('d/m/Y') }}<br>
            <strong>Valor:</strong> R$ {{ number_format($moviment->amount, 2, ',', '.') }}<br>
            <strong>Projeto:</strong> {{ $moviment->projectRel->name }}<br>
            <strong>Status:</strong> {{ $moviment->TypeMoviment->type ?? 'Não definido' }}<br>
            <a href="{{ route('moviments.show', ['moviment' => $moviment->id]) }}">Detalhes</a><br>
            <a href="{{ route('moviments.edit', ['moviment' => $moviment->id]) }}">Editar</a><br>
            <form action="{{ route('moviments.destroy', $moviment->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este registro?')">Excluir</button>
            </form>
        </p>
        <hr>
    @empty
        <p>Nenhuma movimentação encontrada.</p>
    @endforelse
    {{-- Paginação dos resultados --}}
    {{ $moviments->links() }}
@endsection
