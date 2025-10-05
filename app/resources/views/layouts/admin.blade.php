<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gerenciador de projetos</title>

    </head>
<body>
    <a href="{{ route('projects.index') }}">Listar projetos</a><br>
    <a href="{{ route('projects.create') }}">Cadastrar projetos</a><br>
    <a href="{{ route('users.index') }}">Listar usuários</a><br>
    <a href="{{ route('users.create') }}">Cadastrar usuários</a><br>
    <a href="{{ route('status_projs.index') }}">Listar status de projetos</a><br>
    <a href="{{ route('status_projs.create') }}">Cadastrar status de projetos</a><br>
    
    @yield('content')

</body>
</html>