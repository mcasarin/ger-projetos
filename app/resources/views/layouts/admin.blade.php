<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gerenciador de projetos</title>

    </head>
<body>
    <p>Você está logado como: {{ Auth::user()->name }} </p>
    @auth
        <a href="{{ route('dashboard.index') }}" class="btn-home">
            Dashboard
        </a><br>
    @endauth
    @can('index-projects')
    <a href="{{ route('projects.index') }}">Projetos</a><br>
    @endcan
    @can('create-projects')
    {{--<a href="{{ route('projects.create') }}">Cadastrar projetos</a><br>--}}
    @endcan
    @can('index-users')
    <a href="{{ route('users.index') }}">Usuários</a><br>
    @endcan
    <a href="{{ route('profiles.show') }}">Perfil</a><br>
    @can('index-roles')
    <a href="{{ route('roles.index') }}">Papeis</a><br>
    @endcan
    @can('index-permissions')
    <a href="{{ route('permissions.index') }}">Permissões</a><br>
    @endcan
    @can('index-tasks')
    <a href="{{ route('tasks.index') }}">Tarefas</a><br>
    @endcan
    {{--<a href="{{ route('users.create') }}">Cadastrar usuários</a><br>--}}
    {{--<a href="{{ route('status_projs.index') }}">Status de projetos</a><br>--}}
    {{--<a href="{{ route('status_projs.create') }}">Cadastrar status de projetos</a><br>--}}
    @can('index-moviments')
    <a href="{{ route('moviments.index') }}">Movimentações</a><br>
    @endcan
    {{--<a href="{{ route('moviments.create') }}">Cadastrar movimentações</a><br>--}}
    <a href="{{ route('logout') }}">Sair</a><br>
    
    @yield('content')

</body>
</html>