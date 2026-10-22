<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <style>
            body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #f3e8d2; color: #27272a; font-family: 'Courier New', monospace; text-align: center; padding: 1rem; }
            h1 { font-family: Georgia, serif; font-weight: normal; text-transform: uppercase; }
            a { color: inherit; text-transform: uppercase; font-size: .875rem; }
        </style>
    </head>
    <body>
        <div>
            <h1>{{ __('content.error_server') }}</h1>
            <a href="/">{{ __('content.error_back_home') }}</a>
        </div>
    </body>
</html>
