<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Project POS</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite('resources/js/app.js')
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        @if (Auth::check())
            <script>
                window.Laravel = {!!json_encode([
                    'isLoggedIn' => true,
                    'user' => Auth::user()
                ])!!}
            </script>
        @else
            <script>
                window.Laravel = {!!json_encode([
                    'isLoggedIn' => false
                ])!!}
            </script>
        @endif
        <div id="app"></div>
    </body>
</html>
