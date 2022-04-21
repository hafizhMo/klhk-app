@extends('layouts.auth')

@section('content')
<div class="flex">
    <a href="{{ url('/user/dashboard') }}" class="flex-1 bg-gray-900 text-white px-3 py-2 text-base font-medium">Login</a>
    <a href="{{ url('/auth/register') }}" class="flex-1 bg-gray-800 text-white px-3 py-2 text-base font-medium">Dont have any account?</a>
    <a href="{{ url('/auth/forgot-password') }}" class="flex-1 bg-gray-900 text-white px-3 py-2 text-base font-medium">Forgot Password?</a>
</div>
@endsection