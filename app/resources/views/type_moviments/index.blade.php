@extends('layouts.admin')
@section('content')
    <h2>Listagem de Tipos de Movimentações</h2>
    <x-alert />
    <a href="{{ route('moviments.index') }}">Voltar para Movimentações</a>
    <a href="{{ route('type_moviments.create') }}">Cadastrar novo Tipo</a><br><br>
    @forelse ($type_moviments as $type)
        <div class="container">
            <div class="row">
                <div>
                    <strong>ID:</strong> {{ $type->id }} &nbsp;&nbsp; {{ $type->type }}
                </div> 
            </div>
            <br>
        </div>
    @empty
        <p>Nenhum status de tipo encontrado.</p>
    @endforelse
@endsection
