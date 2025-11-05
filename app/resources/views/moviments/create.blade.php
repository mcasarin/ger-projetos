@extends('layouts.admin')
@section('content')
    <h2>Cadastrar Movimento Financeiro</h2>
    <form action="{{ route('moviments.store') }}" method="POST">
        @csrf
        @method('POST')
        <div>
            <label for="project_id">Projeto:</label>
            <input type="text" id="project_id" name="project_id" required>
        </div>
        <div>
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required></textarea>
        </div>
        
        <div>
            <label for="valor">Valor:</label>
            <input type="number" step="0.01" id="valor" name="valor" required>
        </div>
        <div>
            <label for="data_movimentacao">Data da Movimentação:</label>
            <input type="date" id="data_movimentacao" name="data_movimentacao" required>
        </div>
               
        <div>
            <label for="tipo">Tipo:</label>
            <input type="text" id="tipo" name="tipo" required>
        </div>
        <button type="submit">Registrar</button>
    </form>
@endsection
