@extends('layouts.admin')
@section('content')
    <h2>Detalhe do Projeto</h2>

    <a href="{{ route('projects.index') }}">Lista de projetos</a><br><br>
    <x-alert />

        <p>
            <strong>ID:</strong> {{ $project->id }}<br>
            <strong>Nome:</strong> {{ $project->name }}<br>
            <strong>Descrição:</strong> {{ $project->description }}<br>
            <strong>Orçamento Inicial:</strong> {{ $project->initial_budget }}<br>
            <strong>Data de Início:</strong> {{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }}<br>
            <strong>Data de Término:</strong> {{ \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') }}<br>
            <strong>Gerente do Projeto:</strong> {{ $project->project_manager }}<br>
            <strong>Status:</strong> {{ $project->status ? $project->status->name : 'N/A' }}<br>
            <strong>Criado por:</strong> {{ $project->owner_id }}<br>
            <strong>Criado em:</strong> {{ \Carbon\Carbon::parse($project->created_at)->format('d/m/Y H:i:s') }}<br>
            <strong>Atualizado em:</strong> {{ \Carbon\Carbon::parse($project->updated_at)->format('d/m/Y H:i:s') }}<br>
        </p>
@endsection

