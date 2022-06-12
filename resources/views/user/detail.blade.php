@extends('layouts.dashboard')

@section('content')
    <h1>Detail Pengajuan</h1>
    <object data="data:application/pdf;base64,{{ $attachment }}"
        type="application/pdf"
        width="100%" 
        height="100%">
        <p>This browser does not support inline PDFs. Please download the PDF to view it: <a href="data:application/pdf;base64,{{ $attachment }}">Download PDF</a></p>
    </object>
@endsection
