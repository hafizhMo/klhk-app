@extends('layouts.dashboard')

@section('content')
<!-- <div class="flex">
    <a href="{{ url('/user/dashboard') }}" class="flex-1 bg-gray-900 text-white px-3 py-2 text-base font-medium">Submit</a>
</div> -->
<h1 class="text-2xl">Pengajuan surat usaha skala menengah</h1>
<hr class="mt-2">
<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="px-6 py-3">No</th>
          <th scope="col" class="px-6 py-3 text-center">Persyaratan</th>
          <th scope="col" class="px-6 py-3">
            Aksi
            <span class="sr-only"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path><path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path></svg></span>
          </th>
        </tr>
    </thead>
    <tbody>
        <tr class="bg-white border-b text-center">
          <td class="px-6 py-4">1</td>
          <td class="px-6 py-4 text-left">Nomor Induk Berusaha (NIB)</td>
          <td class="px-6 py-4">
            <button >
            <svg class="w-6 h-6 text-gray-700 hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
          </button>
          </td>
        </tr>
        <tr class="bg-white border-b text-center">
          <td class="px-6 py-4">2</td>
          <td class="px-6 py-4 text-left">Akta Pendirian</td>
          <td class="px-6 py-4">
            <button >
            <svg class="w-6 h-6 text-gray-700 hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
          </button>
          </td>
        </tr>
        <tr class="bg-white border-b text-center">
          <td class="px-6 py-4">3</td>
          <td class="px-6 py-4 text-left">Dokumen Lingkungan Hidup berupa Surat Pernyataan Pengelolaan Lingkungan (SPPL) Upaya Pengelolaan Lingkungan dan Upaya Pemantauan Lingkungan (UKL-UPL)</td>
          <td class="px-6 py-4">
            <button >
            <svg class="w-6 h-6 text-gray-700 hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
          </button>
          </td>
        </tr>
        <tr class="bg-white border-b text-center">
          <td class="px-6 py-4">4</td>
          <td class="px-6 py-4 text-left">Proposal Teknis</td>
          <td class="px-6 py-4">
            <button >
            <svg class="w-6 h-6 text-gray-700 hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
          </button>
          </td>
        </tr>
        <tr class="bg-white border-b text-center">
          <td class="px-6 py-4">5</td>
          <td class="px-6 py-4 text-left">Jaminan pasokan bahan baku (dokumen kerjasama pasokan bahan baku atau pernyataan kesanggupan pemenuhan bahan baku dari pemasok)</td>
          <td class="px-6 py-4">
            <button >
            <svg class="w-6 h-6 text-gray-700 hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
          </button>
          </td>
        </tr>
        <tr class="bg-white border-b text-center">
          <td class="px-6 py-4">6</td>
          <td class="px-6 py-4 text-left">Bukti kepemilikan mesin utama produksi pengolahan hasil hutan atau pernyataan kesanggupan pemenuhan rencana pengadaan mesin utama produksi</td>
          <td class="px-6 py-4">
            <button >
            <svg class="w-6 h-6 text-gray-700 hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
          </button>
          </td>
        </tr>
        <tr class="bg-white border-b text-center">
          <td class="px-6 py-4">7</td>
          <td class="px-6 py-4 text-left">Bukti/Dokumen kepemilikan atau penguasaan atas prasarana bangunan pabrik, tempat atau lahan penampungan bahan baku dan gudang kayu olahan </td>
          <td class="px-6 py-4">
            <button >
            <svg class="w-6 h-6 text-gray-700 hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
          </button>
          </td>
        </tr>
        <tr class="bg-white border-b text-center">
          <td class="px-6 py-4">8</td>
          <td class="px-6 py-4 text-left"> Dokumen tenaga kerja professional bersertifikat atau pernyataan komitmen pemenuhan tenaga teknis profesional bersertifikat</td>
          <td class="px-6 py-4">
            <button >
            <svg class="w-6 h-6 text-gray-700 hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
          </button>
          </td>
        </tr>
    </tbody>
</table>
<div class="flex place-content-center">
    <button class="my-8 block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" type="button" data-modal-toggle="reviewModal">Submit</button>
</div>
<div id="reviewModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full justify-center items-center">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Eren Yeager
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="reviewModal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>

            <div class="p-6 text-gray-500">
                <p class="text-base font-medium">Detail</p>
                <p class="leading-relaxed text-base">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <div class="flex mt-4 items-center">
                    <p class="text-base font-medium">Status :</p>
                    <button type="button" class="ml-2 focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-1 dark:focus:ring-yellow-900">Minta Review</button>
                </div>
            </div>

            <div class="flex justify-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                <a href="{{ url('/admin/dashboard') }}" data-modal-toggle="reviewModal" type="button" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Diterima</a>
                <a href="{{ url('/admin/dashboard') }}" data-modal-toggle="reviewModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Revisi</a>
                <a href="{{ url('/admin/dashboard') }}" data-modal-toggle="reviewModal" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Ditolak</a>
            </div>
        </div>
    </div>
</div>
@endsection