<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gerenciador de projetos</title>

    </head>
<body>
    <a href="{{ route('login') }}">Login</a>
    @yield('content')

</body>
</html>