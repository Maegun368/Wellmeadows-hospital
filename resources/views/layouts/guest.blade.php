<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

    <style>
    body { background: #0f2744; font-family: 'Raleway', sans-serif; }

    .wm-input {
        width: 100%; box-sizing: border-box;
        background: #22487a !important; border: none !important;
        border-radius: 8px !important; color: #cde4f7 !important;
        font-size: 14px; padding: 11px 14px !important;
        margin-bottom: 10px; outline: none;
    }
    .wm-input::placeholder { color: #7aaecf; }
    .wm-input:focus { background: #2a5490 !important; }

    .wm-remember {
        display: flex; align-items: center;
        gap: 8px; margin-bottom: 14px;
    }
    .wm-remember label { color: #cde4f7; font-size: 13px; }

    .wm-btn-primary {
        width: 100%; padding: 11px; border-radius: 8px;
        background: #5bc4f5; border: none; color: #0d2a45;
        font-size: 15px; font-weight: 700; cursor: pointer;
        margin-bottom: 10px;
    }
    .wm-btn-primary:hover { background: #3db5ee; }

    .wm-btn-outline {
        width: 100%; padding: 10px; border-radius: 8px;
        background: transparent; border: 1.5px solid #3d6fa0;
        color: #8ec8e8; font-size: 14px; cursor: pointer;
    }
    .wm-btn-outline:hover { border-color: #5bc4f5; color: #5bc4f5; }

    .wm-or {
        color: #7aaecf; font-size: 12px;
        text-align: center; margin: 4px 0 8px;
    }
</style>
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