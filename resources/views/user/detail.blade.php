@extends('layouts.dashboard')

@section('content')
    @if ($jenis === 'kecil')
        <a href="/user/upload-file/low/{{ $id }}">Back</a>
    @elseif ($jenis === 'menengah')
        <a href="/user/upload-file/middle/{{ $id }}">Back</a>
    @else
        <a href="/user/dashboard">Back</a>
    @endif
    <h1>Detail Pengajuan</h1>
    <object data="data:application/pdf;base64,{{ $attachment }}" type="application/pdf" width="100%" height="100%">
        <iframe src="data:application/pdf;base64,{{ $attachment }}" width="100%" height="100%" style="border: none;">
            This browser does not support PDFs. Please download the PDF to view it:
            <p>This browser does not support inline PDFs. Please download the PDF to view it: <a
                    href="data:application/pdf;base64,{{ $attachment }}">Download PDF</a></p>
        </iframe>
    </object>
    <div>
        <h1 class="text-3xl capitalize">Status: {{ $status ?? 'Belum ditentukan' }}</h1>
        <p class="text-xl">Current Approver: {{ $current_approver ?? 'Tidak ada' }}</p>
        @if ($user->role !== 'user')
            <form action="{{ url('/user/detail-file/' . $id . '/' . $filename . '/approve?status=ditolak') }}"
                method="post">
                @csrf
                <button
                    class="mt-8 text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-12 py-2.5">Tolak</button>
            </form>
            <form action="{{ url('/user/detail-file/' . $id . '/' . $filename . '/approve?status=diterima') }}"
                method="post">
                @csrf
                <button
                    class="mt-8 text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-12 py-2.5">Terima</button>
            </form>
        @endif
    </div>
    @if ($user->role !== 'user')
        <div>
            <h1 class="text-3xl">Komentar:</h1>
            @if (count($komentar) > 0)
                <ul>
                    @foreach ($komentar as $value)
                        <li>{{ $value->name }} - {{ $value->komentar }}</li>
                    @endforeach
                </ul>
            @else
                <p>Tidak ada komentar.</p>
            @endif
            <form action="{{ url('/user/detail-file/' . $id . '/' . $filename . '/komentar') }}" method="post">
                @csrf
                <h1 class="text-xl">Beri komentar:</h1>
                <textarea name="komentar" id="" cols="30" rows="10"></textarea>
                <button type="submit">Kirim</button>
            </form>
        </div>
    @endif

@endsection
