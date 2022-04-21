<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <title>Laravel</title>

    </head>
    <body class="min-h-full">
        <div class="bg-gray-800">
            <div class="max-w-7xl mx-auto px-8">
                @yield('content')
            </div>
        </div>
    </body>
</html>