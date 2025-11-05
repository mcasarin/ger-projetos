@extends('layouts.admin')
@section('content')
    <h2>Cadastrar Projeto</h2>
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        @method('POST')
        <div>
            <label for="name">Nome do Projeto:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="description">Descrição:</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        
        <div>
            <label for="start_date">Data Inicial:</label>
            <input type="datetime-local" id="start_date" name="start_date" required>
        </div>
        <div>
            <label for="end_date">Data Final:</label>
            <input type="datetime-local" id="end_date" name="end_date" required>
        </div>
        <div>
            <label for="project_manager">Responsável pelo Projeto:</label>
            <input type="text" name="project_manager" id="project_manager">
        </div>
        <div>
            <label for="initial_budget">Orçamento inicial</label>
            <input type="number" step="0.01" id="initial_budget" name="initial_budget" required>
        </div>
        <button type="submit">Cadastrar</button>
    </form>
@endsection
