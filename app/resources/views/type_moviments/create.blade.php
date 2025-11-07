@extends('layouts.admin')
@section('content')
    <h2>Cadastrar Tipo de Movimentações</h2>
    <form action="{{ route('type_moviments.store') }}" method="POST">
        @csrf
        @method('POST')
        <div>
            <label for="type">Tipo:</label>
            <input type="text" id="type" name="type" required>
        </div>
        <button type="submit">Cadastrar</button>
    </form>
@endsection