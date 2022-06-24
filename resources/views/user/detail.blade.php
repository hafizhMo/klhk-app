@extends('layouts.dashboard')

@section('content')
    <h1>Detail Pengajuan</h1>
    <object data="data:application/pdf;base64,{{ $attachment }}"
        type="application/pdf"
        width="100%"
        height="100%">
        <p>This browser does not support inline PDFs. Please download the PDF to view it: <a href="data:application/pdf;base64,{{ $attachment }}">Download PDF</a></p>
    </object>
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
        <form action="{{ url('/user/detail-file/'. $id .'/' . $filename) }}" method="post">
            @csrf
            <h1 class="text-xl">Beri komentar:</h1>
            <textarea name="komentar" id="" cols="30" rows="10"></textarea>
            <button type="submit">Kirim</button>
        </form>
    </div>
@endsection
