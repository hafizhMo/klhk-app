@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl">Pengajuan surat usaha skala kecil</h1>
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
          <td class="px-6 py-4 text-left">Surat Permohonan ditujukan kepada kepala Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Timur Bermaterai Rp. 10.000,-</td>
          <td class="px-6 py-4">
            <a href="#" class="text-gray-700">
              <svg class="w-6 h-6 hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path><path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path></svg>
            </a>
          </td>
        </tr>
        <tr class="bg-white border-b text-center">
          <td class="px-6 py-4">2</td>
          <td class="px-6 py-4 text-left">Nomor Induk Berusaha (NIB)</td>
          <td class="px-6 py-4">
            <a href="#" class="text-gray-700">
              <svg class="w-6 h-6 hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path><path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path></svg>
            </a>
          </td>
        </tr>
        <tr class="bg-white border-b text-center">
          <td class="px-6 py-4">3</td>
          <td class="px-6 py-4 text-left">Surat Pernyataan Pengelolaan Lingkungan (SPPL)</td>
          <td class="px-6 py-4">
            <a href="#" class="text-gray-700">
              <svg class="w-6 h-6 hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path><path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path></svg>
            </a>
          </td>
        </tr>
        <tr class="bg-white border-b text-center">
          <td class="px-6 py-4">4</td>
          <td class="px-6 py-4 text-left">Surat Pernyataan yang berisi jenis Pengolahan Hasil Hutan, Mesin Utama Produksi, dan kapasitas produksi</td>
          <td class="px-6 py-4">
            <a href="#" class="text-gray-700">
              <svg class="w-6 h-6 hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path><path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path></svg>
            </a>
          </td>
        </tr>
        <tr class="bg-white border-b text-center">
          <td class="px-6 py-4">5</td>
          <td class="px-6 py-4 text-left">Pernyataan Mandiri dari OSS</td>
          <td class="px-6 py-4">
            <a href="#" class="text-gray-700">
              <svg class="w-6 h-6 hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path><path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path></svg>
            </a>
          </td>
        </tr>
    </tbody>
</table>
<div class="flex place-content-center">
    <a href="{{ url('/user/dashboard') }}" class="mt-8 text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-12 py-2.5">
        Berikutnya
    </a>
</div>
@endsection