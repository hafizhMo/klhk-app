@extends('layouts.auth')

@section('content')
<div class="flex">
    <a href="{{ url('/auth/login') }}" class="flex-1 bg-gray-800 text-white px-3 py-2 text-base font-medium">Reset</a>
</div>
@endsection