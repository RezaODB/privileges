<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <style>
        .img-responsive {
            padding: 2rem;
            border-radius: .6rem .5rem 1rem .4rem;
            background-color: #e5decf;
            rotate: 1deg;
        }
    </style>
    <body class="font-sans antialiased bg-gray-100">
        <div class="max-w-screen-xl min-h-screen pb-16 my-8 mx-auto bg-orange-100 shadow-2xl rounded-bl-3xl">
            @include('includes.header')
            <main class="p-4 md:p-8">
                @yield('content')
            </main>
        </div>
        @livewireScripts
    </body>
</html>
