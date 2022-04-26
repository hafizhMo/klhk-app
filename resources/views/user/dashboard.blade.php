@extends('layouts.dashboard')

@section('content')
<h1 class="mt-2 text-2xl">Selamat datang, Eren Yeager!</h1>
<div class="relative overflow-x-auto mt-4 bg-gray-100 p-2 sm:rounded-lg">
    <div class="py-4 flex justify-between">
        <button id="dropdownDefault" data-dropdown-toggle="dropdown" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
        5
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700" data-popper-placement="bottom" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(351.5px, 681px, 0px);">
        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefault">
            <li>
            <a href="" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">5</a>
            </li>
            <li>
            <a href="" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">10</a>
            </li>
            <li>
            <a href="" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">15</a>
            </li>
            <li>
            <a href="" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">20</a>
            </li>
        </ul>
        </div>
        <a href="{{ url('/user/create-file') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
        </a>
    </div>

    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Nama Pengajuan</th>
                <th scope="col" class="px-6 py-3">No. Surat</th>
                <th scope="col" class="px-6 py-3">Tanggal Pengajuan</th>
                <th scope="col" class="px-6 py-3">Perihal</th>
                <th scope="col" class="px-6 py-3">Tanggal Diterima</th>
                <th scope="col" class="px-6 py-3">Skala Usaha</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Aksi
                    <span class="sr-only">View</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">Eren Yeager</th>
                <td class="px-6 py-4">SRT1231231232</td>
                <td class="px-6 py-4">20/04/2022</td>
                <td class="px-6 py-4">Perizinan pembukaan budidaya titan abnormal</td>
                <td class="px-6 py-4">24/04/2022</td>
                <td class="px-6 py-4">Menengah</td>
                <td class="px-6 py-4">Diterima</td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ url('/user/detail-file') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                </td>
            </tr>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">Eren Yeager</th>
                <td class="px-6 py-4">SRT1231231232</td>
                <td class="px-6 py-4">20/04/2022</td>
                <td class="px-6 py-4">Perizinan pembukaan budidaya titan abnormal</td>
                <td class="px-6 py-4">24/04/2022</td>
                <td class="px-6 py-4">Menengah</td>
                <td class="px-6 py-4">Revisi</td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ url('/user/detail-file') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                </td>
            </tr>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">Eren Yeager</th>
                <td class="px-6 py-4">SRT1231231232</td>
                <td class="px-6 py-4">20/04/2022</td>
                <td class="px-6 py-4">Perizinan pembukaan budidaya titan abnormal</td>
                <td class="px-6 py-4">24/04/2022</td>
                <td class="px-6 py-4">Kecil</td>
                <td class="px-6 py-4">Verifikasi Lapangan</td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ url('/user/detail-file') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                </td>
            </tr>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">Eren Yeager</th>
                <td class="px-6 py-4">SRT1231231232</td>
                <td class="px-6 py-4">20/04/2022</td>
                <td class="px-6 py-4">Perizinan pembukaan budidaya titan abnormal</td>
                <td class="px-6 py-4">24/04/2022</td>
                <td class="px-6 py-4">Menengah</td>
                <td class="px-6 py-4">Ditolak</td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ url('/user/detail-file') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                </td>
            </tr>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">Eren Yeager</th>
                <td class="px-6 py-4">SRT1231231232</td>
                <td class="px-6 py-4">20/04/2022</td>
                <td class="px-6 py-4">Perizinan pembukaan budidaya titan abnormal</td>
                <td class="px-6 py-4">24/04/2022</td>
                <td class="px-6 py-4">Kecil</td>
                <td class="px-6 py-4">Verifikasi Lapangan</td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ url('/user/detail-file') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="flex flex-wrap mt-8">
    <div class="flex items-center mr-6">
        <div class="h-10 w-10 rounded-lg bg-yellow-100 flex flex-wrap justify-center items-center"></div>
        <p class="text-sm font-normal ml-2 text-gray-700" >Menunggu Review</p>
    </div>
    <div class="flex items-center mr-6">
        <div class="h-10 w-10 rounded-lg bg-green-200 flex flex-wrap justify-center items-center"></div>
        <p class="text-sm font-normal ml-2 text-gray-700" >Disetujui</p>
    </div>
    <div class="flex items-center mr-6">
        <div class="h-10 w-10 rounded-lg bg-red-200 flex flex-wrap justify-center items-center"></div>
        <p class="text-sm font-normal ml-2 text-gray-700" >Ditolak</p>
    </div>
</div>
@endsection