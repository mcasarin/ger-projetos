@extends('layouts.admin')

@section('content')
    <h2>Editar Permissão</h2>

    @can('index-permission')
        <a href="{{ route('permissions.index') }}">Listar</a><br>
    @endcan

    @can('show-permission')
        <a href="{{ route('permissions.show', ['permission' => $permission->id]) }}">Visualizar</a><br><br>
    @endcan

    <x-alert />

    <form action="{{ route('permissions.update', ['permission' => $permission->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Título: </label>
        <input type="text" name="title" id="title" placeholder="Título da permissão" value="{{ old('title', $permission->title) }}"
            required><br><br>

        <label>Nome: </label>
        <input type="text" name="name" id="name" placeholder="Nome da permissão" value="{{ old('name', $permission->name) }}"
            required><br><br>

        <button type="submit">Salvar</button>
    </form>
@endsection
