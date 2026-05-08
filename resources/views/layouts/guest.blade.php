<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            html, body { margin: 0; padding: 0; width: 100%; height: 100%; }
        </style>
    </head>
    <body>
        <div style="
            width: 100%;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('{{ asset('image/bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        ">
            <div style="width: 100%; max-width: 360px; padding: 1rem;">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>