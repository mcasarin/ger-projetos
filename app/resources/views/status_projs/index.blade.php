@extends('layouts.admin')
@section('content')
    <h2>Listagem de Status dos Projetos</h2>
    <x-alert />
    
    @forelse ($status_proj as $status)
        <p>
            <strong>ID:</strong> {{ $status->id }}<br>
            <strong>Nome:</strong> {{ $status->status }}<br>
        </p>
    @empty
        <p>Nenhum status de projeto encontrado.</p>
    @endforelse
@endsection
