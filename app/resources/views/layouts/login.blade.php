<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gerenciador de projetos</title>
        @vite(['resources/css/app.css', 'resources/js/app_auth.js'])
    </head>
<body class="bg-login">

    <div class="card-login">
        <div class="logo-wrapper-login">
            <a href="{{ route('login') }}">
                <img src="{{ asset('images/logo_gerproj.png') }}" alt="Logo" class="logo-login">
            </a>
        </div>
    
        @yield('content')
    
    </div>

</body>
</html>