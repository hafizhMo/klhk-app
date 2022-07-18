@php
$input = [
    (object) [
        'nama_input' => 'Surat Permohonan ditujukan kepada kepala Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Timur Bermaterai Rp. 10.000,-',
        'input_id' => 'surat_permohonan',
        'url' => '',
        'available' => false,
    ],
    (object) [
        'nama_input' => 'Nomor Induk Berusaha (NIB)',
        'input_id' => 'nib',
        'url' => '',
        'available' => false,
    ],
    (object) [
        'nama_input' => 'Surat Pernyataan Pengelolaan Lingkungan (SPPL)',
        'input_id' => 'sppl',
        'url' => '',
        'available' => false,
    ],
    (object) [
        'nama_input' => 'Surat Pernyataan yang berisi jenis Pengolahan Hasil Hutan, Mesin Utama Produksi, dan kapasitas produksi',
        'input_id' => 'surat_pernyataan',
        'url' => '',
        'available' => false,
    ],
    (object) [
        'nama_input' => 'Pernyataan Mandiri dari OSS',
        'input_id' => 'pernyataan_oss',
        'url' => '',
        'available' => false,
    ],
];

foreach ($detail_pengajuan as $value) {
    $url = $value->id_pengajuan . '/' . $value->name;
    switch ($value->jenis_file) {
        case 'surat_permohonan':
            $input[0]->available = true;
            $input[0]->url = $url;
            break;
        case 'nib':
            $input[1]->available = true;
            $input[1]->url = $url;
            break;
        case 'sppl':
            $input[2]->available = true;
            $input[2]->url = $url;
            break;
        case 'surat_pernyataan':
            $input[3]->available = true;
            $input[3]->url = $url;
            break;
        case 'pernyataan_oss':
            $input[4]->available = true;
            $input[4]->url = $url;
            break;
    }
}
@endphp

@extends('layouts.dashboard')

@section('content')
    <h1 class="text-2xl">Pengajuan surat usaha skala kecil</h1>
    <hr class="mt-2">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3 text-center">Persyaratan</th>
                <th scope="col" class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < count($input); $i++)
                <tr class="bg-white border-b text-center">
                    <td class="px-6 py-4">{{ $i + 1 }}</td>
                    <td class="px-6 py-4 text-left">{{ $input[$i]->nama_input }}</td>
                    <td class="px-6 py-4">
                        <button type="button" data-modal-toggle="{{ $input[$i]->input_id }}">
                            <svg class="w-6 h-6 text-gray-700 hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z">
                                </path>
                                <path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path>
                            </svg>
                        </button>
                    </td>
                </tr>
            @endfor
            @if ($file_approval !== null)
                <tr class="bg-white border-b text-center">
                    <td class="px-6 py-4"></td>
                    <td class="px-6 py-4 text-left">{{ $status === 'ditolak' ? 'Surat Penolakan' : 'Surat Persetujuan' }}</td>
                    <td class="px-6 py-4">
                        <button type="button" data-modal-toggle="suratApprovalModal">
                            <svg class="w-6 h-6 text-gray-700 hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z">
                                </path>
                                <path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path>
                            </svg>
                        </button>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class="flex place-content-center">
        @if ($user->role === 'user')
            @if ($status === 'not submitted' || $status === 'ditolak')
                <form action="{{ url('user/upload-file/low/' . $page_id . '/send') }}" method="post">
                    @csrf
                    <button
                        class="mt-8 text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-12 py-2.5">Kirim</button>
                </form>
            @endif
        @else
            @if ($status === 'pending' && $approved === false)
                <button class="mt-8 text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-12 py-2.5"
                    data-modal-toggle="tolakPengajuanModal">Tolak</button>
                <button class="mt-8 text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-12 py-2.5"
                    data-modal-toggle="terimaPengajuanModal">Terima</button>
            @endif
        @endif
    </div>
    @foreach ($input as $data)
        <div id="{{ $data->input_id }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full justify-center items-center">
            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                @if ($user->role === 'user')
                    <form method="POST" action="{{ url('user/upload-file/low/' . $page_id) }}"
                        class="relative bg-white rounded-lg shadow dark:bg-gray-700" enctype="multipart/form-data">
                        @csrf
                        <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ $data->nama_input }}
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-toggle="{{ $data->input_id }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="flex p-6 text-gray-500 text-base justify-center">
                            @if ($data->available)
                                {{-- <label for="{{ $data->input_id }}" class="cursor-pointer">
                                <svg class="mr-4 w-12 h-12 text-gray-700 hover:text-gray-500" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </label>
                            <input type="file" name="{{ $data->input_id }}" id="{{ $data->input_id }}" hidden> --}}
                                <a href="{{ url('user/detail-file/' . $data->url) }}">
                                    <svg class="ml-4 mr-4 w-12 h-12 text-gray-700 hover:text-gray-500" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            @endif
                            @if ($status === 'not submitted' || $status === 'ditolak')
                                <input type="file" name="{{ $data->input_id }}" id="{{ $data->input_id }}"
                                    accept="application/pdf" required>
                            @endif
                        </div>
                        <div
                            class="flex justify-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                            @if ($status === 'not submitted' || $status === 'ditolak')
                                <button data-modal-toggle="{{ $data->input_id }}" type="submit"
                                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Submit</button>
                            @endif
                        </div>
                    </form>
                @else
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                        <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ $data->nama_input }}
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-toggle="{{ $data->input_id }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="flex p-6 text-gray-500 text-base justify-center">
                            @if (!$data->available)
                                <p>Dokumen tidak tersedia.</p>
                            @else
                                <a href="{{ url('user/detail-file/' . $data->url) }}">
                                    <svg class="ml-4 w-12 h-12 text-gray-700 hover:text-gray-500" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
    @if ($user->role !== 'user')
        <div id="tolakPengajuanModal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Tolak pengajuan ini?
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="tolakPengajuanModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <form action="{{ url('user/upload-file/low/' . $page_id . '/approve?status=ditolak') }}"
                        class="relative bg-white rounded-lg shadow dark:bg-gray-700" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="p-6 space-y-6">
                            <input type="file" name="surat_penolakan" id="surat_penolakan" accept="application/pdf"
                                required>
                        </div>
                        <div
                            class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                            <button type="submit"
                                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="terimaPengajuanModal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Terima pengajuan ini?
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="terimaPengajuanModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <form action="{{ url('user/upload-file/low/' . $page_id . '/approve?status=diterima') }}"
                        class="relative bg-white rounded-lg shadow dark:bg-gray-700" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="p-6 space-y-6">
                            <input type="file" name="surat_persetujuan" id="surat_persetujuan"
                                accept="application/pdf" required>
                        </div>
                        <div
                            class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                            <button type="submit"
                                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Terima</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    @if ($file_approval !== null)
        <div id="suratApprovalModal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-screen md:h-screen">
            <div class="relative p-4 w-full h-full md:h-full">
                <!-- Modal content -->
                <div class="h-full w-full relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            {{ $status === 'ditolak' ? 'Surat Penolakan' : 'Surat Persetujuan' }}
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="suratApprovalModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="h-fit w-fit relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="h-[75vh] w-[75vw] p-6 space-y-6">
                            <object data="data:application/pdf;base64,{{ $file_approval }}" type="application/pdf"
                                width="100%" height="100%">
                                <iframe src="data:application/pdf;base64,{{ $file_approval }}" width="100%"
                                    height="100%" style="border: none;">
                                    This browser does not support PDFs. Please download the PDF to view it:
                                    <p>This browser does not support inline PDFs. Please download the PDF to view it: <a
                                            href="data:application/pdf;base64,{{ $file_approval }}">Download PDF</a>
                                    </p>
                                </iframe>
                            </object>
                        </div>
                        <div
                            class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                            <button data-modal-toggle="suratApprovalModal" type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (Session::has('error'))
        <div id="errorModal" tabindex="-1" aria-hidden="true" data-modal-show="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Peringatan
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="errorModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="p-6 space-y-6">
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                {{ Session::get('error') }}
                            </p>
                        </div>
                        <div
                            class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                            <button data-modal-toggle="errorModal" type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
