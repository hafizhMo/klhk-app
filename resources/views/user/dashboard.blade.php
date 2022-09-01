@extends('layouts.dashboard')

@section('content')
    <h1 class="mt-2 text-2xl">Selamat datang, {{ $user->name }}!</h1>
    <div class="relative overflow-x-auto mt-4 bg-gray-100 p-2 sm:rounded-lg">
        <div class="py-4 flex justify-between">
            <button id="dropdownDefault" data-dropdown-toggle="dropdown"
                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                type="button">
                5
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700"
                data-popper-placement="bottom"
                style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(351.5px, 681px, 0px);">
                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefault">
                    <li>
                        <a href=""
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">5</a>
                    </li>
                    <li>
                        <a href=""
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">10</a>
                    </li>
                    <li>
                        <a href=""
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">15</a>
                    </li>
                    <li>
                        <a href=""
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">20</a>
                    </li>
                </ul>
            </div>
            @if ($user->role === 'user')
            <a href="{{ url('user/create-file') }}"
                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </a>
            @endif
        </div>

        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="dashboard_grid">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Nama Pengajuan</th>
                    <th scope="col" class="px-6 py-3">No. Surat</th>
                    <th scope="col" class="px-6 py-3">Tanggal Pengajuan</th>
                    <th scope="col" class="px-6 py-3">Perihal</th>
                    <th scope="col" class="px-6 py-3">Skala Usaha</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Aksi
                        <span class="sr-only">View</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengajuan as $data)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $data->nama_pengajuan }}</th>
                        <td class="px-6 py-4">{{ $data->no_surat }}</td>
                        <td class="px-6 py-4">{{ $data->created_at }}</td>
                        <td class="px-6 py-4">{{ $data->perihal }}</td>
                        <td class="px-6 py-4 capitalize">{{ $data->skala_usaha }}</td>
                        <td class="px-6 py-4 capitalize">{{ $data->status }}</td>
                        <td class="px-6 py-4 text-right">
                            <button
                                class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                                type="button" data-modal-toggle="modal-{{ $data->id }}">View</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex flex-wrap mt-8">
        <div class="flex items-center mr-6">
            <div class="h-10 w-10 rounded-lg bg-yellow-100 flex flex-wrap justify-center items-center"></div>
            <p class="text-sm font-normal ml-2 text-gray-700">Menunggu Review</p>
        </div>
        <div class="flex items-center mr-6">
            <div class="h-10 w-10 rounded-lg bg-green-200 flex flex-wrap justify-center items-center"></div>
            <p class="text-sm font-normal ml-2 text-gray-700">Disetujui</p>
        </div>
        <div class="flex items-center mr-6">
            <div class="h-10 w-10 rounded-lg bg-red-200 flex flex-wrap justify-center items-center"></div>
            <p class="text-sm font-normal ml-2 text-gray-700">Ditolak</p>
        </div>

        <div id="modalDetail" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 left-0 right-0 z-50 w-full h-modal">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex justify-between items-start p-4 rounded-t border-b">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Nama Pengajuan
                    </h3>
                </div>
            </div>
        </div>
    </div>
    @foreach ($pengajuan as $data)
        <div id="modal-{{ $data->id }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full justify-center items-center">
            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Nama Pengajuan
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="modal-{{ $data->id }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex p-6 text-gray-500 text-base">
                        <div class="font-medium mr-8 space-y-4 ">
                            <p class="text-base">No Surat</p>
                            <p class="text-base">Tanggal</p>
                            <p class="text-base">Perihal</p>
                            <p class="text-base">Skala Usaha</p>
                            <p class="text-base">Status</p>
                        </div>
                        <div class="font-regular space-y-4">
                            <p class="text-base">: {{ $data->no_surat }}</p>
                            <p class="text-base">: {{ $data->created_at }}</p>
                            <p class="text-base">: {{ $data->perihal }}</p>
                            <p class="text-base capitalize">: {{ $data->skala_usaha }}</p>
                            <p class="text-base capitalize">: {{ $data->status }}</p>
                        </div>
                    </div>
                    <div class="flex justify-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                        @if ($data->skala_usaha === 'kecil')
                            <a href="{{ url('user/upload-file/low/' . $data->id) }}"
                                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Lihat
                                detail</a>
                        @elseif ($data->skala_usaha === 'menengah')
                            <a href="{{ url('user/upload-file/middle/' . $data->id) }}"
                                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Lihat
                                detail</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
