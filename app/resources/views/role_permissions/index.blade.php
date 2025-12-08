@extends('layouts.admin')

@section('content')
    <h2>Permissões do papel - {{ $role->name }}</h2>

    @can('index-role')
        <a href="{{ route('roles.index') }}">Listar papéis</a><br><br>
    @endcan


    <x-alert />

    {{-- Imprimir os registros --}}
    @forelse ($permissions as $permission)
        ID: {{ $permission->id }}<br>
        Nome: {{ $permission->name }}<br>
        Papel: {{ $role->name }}<br>
        <!-- Valida se o papel possui permissão, se não tiver cria um array vazio -->
        @if(in_array($permission->id, $rolePermissions ?? []))
        <a href="{{ route('role-permission.update', ['role' => $role->id, 'permission' => $permission->id]) }}">
            <span style="color:#086;">Liberado</span>
        </a>
            
        @else
        <a href="{{ route('role-permission.update', ['role' => $role->id, 'permission' => $permission->id]) }}">
            <span style="color:#f00;">Bloqueado</span>
        </a>
            
        @endif
        <hr>
    @empty
        Nenhum registro encontrado!
    @endforelse

@endsection
