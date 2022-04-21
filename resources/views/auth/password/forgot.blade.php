@extends('layouts.auth')

@section('content')
<div class="flex">
    <a href="{{ url('/auth/login') }}" class="flex-1 bg-gray-900 text-white px-3 py-2 text-base font-medium">Forgot</a>
    <a href="{{ url('/auth/reset-password') }}" class="flex-1 bg-gray-900 text-white px-3 py-2 text-base font-medium">Reset Password?</a>
</div>
@endsection