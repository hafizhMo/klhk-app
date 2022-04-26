<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->

        <title>Dinas Kehutanan Provinsi Jawa Timur</title>

        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/flowbite@latest/dist/flowbite.min.css" />
    </head>
    <body>
        <div class="flex w-full h-screen">
            @yield('content')
        </div>
    </body>
</html>