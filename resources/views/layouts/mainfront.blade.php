<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="shortcut icon" href="{{ asset('imgs/favicon.ico') }}" type="image/vnd.microsoft.icon" />
        <title>Incibe Formación</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="{{ asset('css/fontawesome-all.css') }}" rel="stylesheet">

        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />  --}}
        {{-- <link href="{{ asset('css/tw-elements.min.css') }}" rel="stylesheet" type="text/css"> --}}
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

        <link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet" type="text/css">
        {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.css">

        <!-- Styles -->
        @vite('resources/css/app.css')

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');

            /* body {
                font-family: 'Nunito', sans-serif;
            } */
        </style>
    </head>
    <body class="antialiased">

         @yield('content')

        {{-- <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script> --}}
        {{-- <script src="{{ asset('js/tw-elements.umd.min.js') }}"></script> --}}
        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/sweetalert.min.js') }}"></script>
        <script src="{{ asset('js/jquery.sweet-alert.custom.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js" defer></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script> --}}
        <script src="{{ asset('js/flatpickr.js') }}"></script>
        <script src="{{ asset('js/es.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>

        @yield('script')
    </body>
