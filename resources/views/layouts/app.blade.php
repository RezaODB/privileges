<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
        <script>
        tinymce.init({
        selector: '.editor',
        image_class_list: [
            { title: 'one-column', value: 'one-col' },
            { title: 'two-column', value: 'two-col' },
        ],
        plugins: 'link lists paste code image media wordcount code',
        toolbar: 'h2 h3 | bold italic blockquote indent aligncenter | numlist bullist | link image media code',
        menubar: false,
        paste_as_text: true,
        image_title: true,
        automatic_uploads: true,
        images_file_types: 'jpg,jpeg,png,webp,gif',

        // On gère l’upload proprement (CSRF + réponse JSON stable)
        images_upload_url: null,

        images_upload_handler: function (blobInfo, progress) {
            return new Promise(function (resolve, reject) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('upload') }}');

            var token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (token) xhr.setRequestHeader('X-CSRF-TOKEN', token);

            xhr.upload.onprogress = function (e) {
                if (e.lengthComputable) progress(Math.round((e.loaded / e.total) * 100));
            };

            xhr.onload = function () {
                if (xhr.status === 403) return reject({ message: 'Forbidden (403)', remove: true });
                if (xhr.status === 419) return reject({ message: 'CSRF expired (419). Refresh the page.', remove: true });
                if (xhr.status < 200 || xhr.status >= 300) return reject('HTTP Error: ' + xhr.status);

                var json;
                try { json = JSON.parse(xhr.responseText); } catch (e) { return reject('Invalid JSON: ' + xhr.responseText); }
                if (!json || typeof json.location !== 'string') return reject('Invalid response: missing "location".');

                resolve(json.location);
            };

            xhr.onerror = function () {
                reject('Upload failed (network error).');
            };

            var formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
            });
        }
        });
        </script>
        @livewireStyles
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100" x-data="{ open: false }" x-on:keydown.escape.window="open = false">

            <div class="lg:hidden sticky top-0 z-30 flex items-center gap-3 h-16 px-4 bg-white border-b border-gray-200">
                <button type="button" x-on:click="open = true" class="-ms-2 p-2 text-gray-500 hover:text-gray-700" aria-label="Ouvrir le menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <span class="font-semibold">Les privilèges invisibles</span>
            </div>

            <div x-cloak x-show="open" x-transition.opacity x-on:click="open = false" class="fixed inset-0 z-30 bg-black/30 lg:hidden"></div>

            @include('layouts.navigation')

            <main class="lg:ps-64">
                {{ $slot }}
            </main>

        </div>
        @livewireScripts
    </body>
</html>
