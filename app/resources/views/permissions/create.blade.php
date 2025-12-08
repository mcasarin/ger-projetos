@extends('layouts.admin')

@section('content')
    <h2>Cadastrar Permissão</h2>

    @can('index-permission')
        <a href="{{ route('permissions.index') }}">Listar</a><br><br>
    @endcan

    <x-alert />

    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        @method('POST')
        <label>Título: </label>
        <input type="text" name="title" id="title" placeholder="Título da Permissão" value="{{ old('title') }}"
            required><br><br>

        <label>Nome: </label>
        <input type="text" name="name" id="name" placeholder="Nome da Permissão" value="{{ old('name') }}"
            required><br><br>

        <button type="submit">Cadastrar</button>
    </form>
@endsection
