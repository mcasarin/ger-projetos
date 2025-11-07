@extends('layouts.admin')
@section('content')
    <h2>Detalhe da Movimentação</h2>

    <a href="{{ route('moviments.index') }}">Voltar para a lista</a><br><br>
    <x-alert />

        <p>
            <strong>ID:</strong> {{ $moviment->id }}<br>
            <strong>Descrição:</strong> {{ $moviment->description }}<br>
            <strong>Projeto:</strong> {{ $moviment->projectRel->name }}<br>
            <strong>Data:</strong> {{ \Carbon\Carbon::parse($moviment->date_moviment)->format('d/m/Y') }}<br>
            <strong>Tipo:</strong> {{ $moviment->TypeMoviment->type }}<br>
            <strong>Valor:</strong> R$ {{ number_format($moviment->amount, 2, ',', '.') }}<br>
            <strong>Criado em:</strong> {{ \Carbon\Carbon::parse($moviment->created_at)->format('d/m/Y H:i:s') }}<br>
            <strong>Atualizado em:</strong> {{ \Carbon\Carbon::parse($moviment->updated_at)->format('d/m/Y H:i:s') }}<br>
        </p>
@endsection

