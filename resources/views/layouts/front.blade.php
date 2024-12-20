<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <style>
        .one-col {
            padding: 1.5rem;
            margin: auto; 
            background-color: #f3e3d3;
        }
        .two-col {
            padding: 1.5rem;
            margin: 2rem auto; 
            background-color: #f3e3d3;
            column-span: all; 
        }
        blockquote p {
            text-align: center !important;
            quotes: none !important;
        }
    </style>
    <body class="font-sans antialiased bg-gray-100 text-zinc-800">
        <div class="max-w-screen-2xl mx-auto sm:px-4">
            <div class="min-h-screen pb-16 sm:my-4 bg-[#e5d0b5] shadow-2xl relative rounded-t-xl rounded-b-md overflow-hidden">
                <div class="absolute inset-0 pointer-events-none opacity-50" style="background-image: url({{ asset('folder.png') }}); background-size: 100% auto;"></div>
                <header class="relative">
                    @include('includes.header')
                </header>
                <main class="py-8 sm:px-8 relative">
                    @yield('content')
                </main>
            </div>
        </div>
        @livewireScripts
    </body>
</html>
