<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->

        <title>Dinas Kehutanan Provinsi Jawa Timur</title>

        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/flowbite@latest/dist/flowbite.min.css" />
        <script src="https://unpkg.com/flowbite@1.4.5/dist/flowbite.js"></script>
    </head>

    <body>
        <div class="flex w-full">
            <div class="w-1/5 bg-green-700 p-6">
                <a href="{{ url('user/dashboard') }}">
                    <img src="https://dishut.jatimprov.go.id/portal/public/fe/images/logo.png" alt="image-logo-dinas-kehutanan">
                </a>
            </div>
            <div class="w-full flex flex-wrap items-center place-content-end p-6">
                <div class="h-8 w-8 rounded-full bg-red-200 flex flex-wrap justify-center items-center">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                </div>
                <a href="#" class="flex flex-wrap hover:bg-gray-100 ml-2 p-2">
                    <h2 class="font-semibold text-sm">{{ $user->name }}</h2>
                    <svg class="w-6 h-6 ml-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a>
            </div>
        </div>
        <hr class="text-gray-500">
        <div class="flex w-full h-fit">
            <div class="w-1/5 bg-green-700 p-6">
                <p class="text-gray-300 text-xs">MENU</p>
                <a href="#" class="flex flex-wrap bg-green-800 text-white items-center mt-2 p-2 hover:bg-green-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm9 4a1 1 0 10-2 0v6a1 1 0 102 0V7zm-3 2a1 1 0 10-2 0v4a1 1 0 102 0V9zm-3 3a1 1 0 10-2 0v1a1 1 0 102 0v-1z" clip-rule="evenodd"></path></svg>
                    <h2 class="ml-1 font-semibold text-sm">Dashboard</h2>
                </a>
            </div>

            <div class="w-full py-4 px-6">
                @yield('content')
            </div>
        </div>
    </body>
</html>
