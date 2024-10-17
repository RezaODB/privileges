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
        <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <style>
        .img-responsive {
            box-shadow: 3px 3px 6px rgb(0, 0, 0, 0.1);
        }
        #postit p {
            padding: 3rem 1rem 1rem 1rem;
            margin-top: 2rem;
            background-image: url("{{ asset('paper.png') }}");
            background-size: cover;
            position: relative;
            box-shadow: 3px 3px 6px rgb(0, 0, 0, 0.1);
            transform: rotate(-1deg);
        }
        #postit p::after {
            content: '';
            position: absolute;
            display: block;
            background-image: url("{{ asset('tape.png') }}");
            background-size: cover;
            width: 200px;
            height: 4rem;
            top: -2rem;
            left: 2rem;
        }
    </style>
    <body class="font-sans antialiased bg-gray-100">
        <div class="max-w-screen-xl min-h-screen pb-16 my-8 mx-auto bg-orange-100 shadow-2xl relative">
            <div class="absolute inset-0 opacity-30 mix-blend-multiply pointer-events-none" style="background-image: url({{ asset('texture.png') }})"></div>
            <header class="relative">
                @include('includes.header')
            </header>
            <main class="p-4 md:p-8 relative">
                @yield('content')
            </main>
        </div>
        @livewireScripts
    </body>
</html>
