@extends('layouts.admin')
@section('content')
    <h2>Cadastrar Tipo de Movimentações</h2>
    <form action="{{ route('type_moviment.store') }}" method="POST">
        @csrf
        @method('POST')
        <div>
            <label for="tipo">Tipo:</label>
            <input type="text" id="tipo" name="tipo" required>
        </div>
        <button type="submit">Cadastrar</button>
    </form>
@endsection