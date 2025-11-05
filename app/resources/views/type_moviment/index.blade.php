@extends('layouts.admin')
@section('content')
    <h2>Listagem de Tipos de Movimentações</h2>
    <x-alert />
    
    @forelse ($type_moviment as $type)
        <p>
            <strong>ID:</strong> {{ $type->id }}<br>
            <strong>Nome:</strong> {{ $type->tipo }}<br>
        </p>
    @empty
        <p>Nenhum status de tipo encontrado.</p>
    @endforelse
@endsection
