@extends('layouts.admin')
@section('content')
<!-- Título e Trilha de Navegação -->
    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Perfil</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <span>Perfil</span>
            </nav>
        </div>
    </div>
    <div class="content-box">
        <div class="content-box-header">
            <h3 class="content-box-title">Perfil</h3>
            <div class="content-box-btn">
                @can('edit-password-profile')
                    <a href="{{ route('profiles.edit_password', ['user' => $user->id]) }}" class="btn-info align-icon-btn">
                        <!-- Ícone key (Heroicons) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                        </svg>

                        <span>Mudar Senha</span>
                    </a>
                @endcan
            </div>
            <div class="content-box-btn">
                @can('edit-profile')
                    <a href="{{ route('profiles.edit', ['user' => $user->id]) }}" class="btn-info align-icon-btn">
                        <!-- Ícone paint-brush (Heroicons) -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42" />
                        </svg>

                        <span>Editar perfil</span>
                    </a>
                @endcan
            </div>
        </div>

    <x-alert />
    
        <div class="detail-box">

            <div class="mb-1">
                <span class="title-detail-content">ID:</span>
                <span class="detail-content">{{ $user->id }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Nome:</span>
                <span class="detail-content">{{ $user->name }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Email:</span>
                <span class="detail-content">{{ $user->email }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Status:</span>
                <span class="detail-content">{{ $user->userStatus ? $user->userStatus->status : 'N/A' }}</span>
            </div>
            
        </div>
    </div>
</div>

@endsection
