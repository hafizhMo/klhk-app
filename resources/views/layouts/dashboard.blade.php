@php
Debugbar::info($notifikasi);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dinas Kehutanan Provinsi Jawa Timur</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://unpkg.com/flowbite@latest/dist/flowbite.min.css" />
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://unpkg.com/flowbite@1.4.5/dist/flowbite.js"></script>
</head>

<body>
    <div class="flex w-full">
        <div class="w-1/5 bg-green-700 p-6">
            <a href="{{ url('user/dashboard') }}">
                <img src="https://dishut.jatimprov.go.id/portal/public/fe/images/logo.png"
                    alt="image-logo-dinas-kehutanan">
            </a>
        </div>
        <div class="w-full flex flex-wrap items-center place-content-end p-6">
            <p id="" data-dropdown-toggle="dropdown-notif" class="h-6 w-6 mr-5 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416H416c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z" />
                </svg>
            </p>
            <div id="dropdown-notif"
                class="p-3 hidden z-10 w-96 bg-gray-100 rounded divide-y divide-gray-100 shadow dark:bg-gray-700">
                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefault">
                    @if (count($notifikasi) > 0)
                        @for ($i = 0; $i < count($notifikasi) % 10; $i++)
                            <li class="mb-3 bg-gray-300 hover:bg-gray-400">
                                <a href="{{ $notifikasi[$i]->url }}">{{ $notifikasi[$i]->konten }}, {{ $notifikasi[$i]->created_at }}</a>
                            </li>
                        @endfor
                    @else
                        <p>Tidak ada notifikasi</p>
                    @endif
                </ul>
                <button
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button" data-modal-toggle="notifikasiModal">Lihat lebih banyak notifikasi</button>
            </div>
            <div id="notifikasiModal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-[calc(100vh-2rem)] md:h-screen">
                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                    <div class="relative bg-white rounded-lg shadow h-full dark:bg-gray-700 overflow-y-scroll">
                        <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="notifikasiModal">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <ul class="h-[80vh] p-6 space-y-6">
                            @if (count($notifikasi) > 0)
                                @foreach ($notifikasi as $notif)
                                    <li class="mb-3 bg-gray-300 hover:bg-gray-400">
                                        <a href="{{ $notif->url }}">{{ $notif->konten }}, {{ $notif->created_at }}</a>
                                    </li>
                                @endforeach
                            @else
                                <p>Tidak ada notifikasi</p>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="h-8 w-8 rounded-full bg-red-200 flex flex-wrap justify-center items-center">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <button data-dropdown-toggle="dropdownProfile" class="flex flex-wrap hover:bg-gray-100 ml-2 p-2">
                <h2 class="font-semibold text-sm">{{ $user->name }}</h2>
                <svg class="w-6 h-6 ml-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
            <div id="dropdownProfile" class="hidden z-10 h-fit w-44 p-5 bg-gray-100 rounded divide-y divide-gray-100 shadow dark:bg-gray-700">
                <form action="{{ url('/user/logout') }}" method="post" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full flex flex-wrap bg-green-800 text-white items-center mt-2 p-2 hover:bg-green-600">Logout</button>
                </form>
            </div>
        </div>
    </div>
    <hr class="text-gray-500">
    <div class="flex w-full h-screen">
        <div class="w-1/5 bg-green-700 p-6">
            <p class="text-gray-300 text-xs">MENU</p>
            <a href="{{ url('user/dashboard') }}"
                class="flex flex-wrap bg-green-800 text-white items-center mt-2 p-2 hover:bg-green-600">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm9 4a1 1 0 10-2 0v6a1 1 0 102 0V7zm-3 2a1 1 0 10-2 0v4a1 1 0 102 0V9zm-3 3a1 1 0 10-2 0v1a1 1 0 102 0v-1z"
                        clip-rule="evenodd"></path>
                </svg>
                <h2 class="ml-1 font-semibold text-sm">Dashboard</h2>
            </a>
        </div>

        <div class="w-full py-4 px-6">
            @yield('content')
        </div>
    </div>
</body>

</html>
