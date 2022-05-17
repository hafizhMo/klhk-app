@extends('layouts.dashboard')

@section('content')
<h1 class="mt-2 text-2xl">Pengajuan</h1>
<hr class="mt-2">
<div class="flex mt-8 text-gray-500 text-base">
    <div class="font-medium mr-8 space-y-4 ">
        <p class="text-base">Nama Pengajuan</p>
        <p class="text-base">No Surat</p>
        <p class="text-base">Tanggal</p>
        <p class="text-base">Perihal</p>
        <p class="text-base">Tanggal Diterima</p>
        <p class="text-base">Skala Usaha</p>
    </div>
    <div class="font-regular space-y-4 ">
        <p class="text-base">: Eren Yeager</p>
        <p class="text-base">: SRT1231231232</p>
        <p class="text-base">: 20/04/2022</p>
        <p class="text-base">: Perizinan pembukaan budidaya titan abnormal</p>
        <p class="text-base">: 20/04/2022</p>
        <p class="text-base">: Menengah</p>
    </div>
</div>
<div class="flex place-content-center">
    <a href="{{ url('/admin/berkas') }}" class="mt-8 text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-12 py-2.5">
        Berikutnya
    </a>
</div>
    
@endsection