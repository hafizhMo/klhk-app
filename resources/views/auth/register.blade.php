@extends('layouts.auth')

@section('content')
<div class="flex">
    <a href="{{ url('/user/dashboard') }}" class="flex-1 bg-gray-900 text-white px-3 py-2 text-base font-medium">Register</a>
    <a href="{{ url('/auth/login') }}" class="flex-1 bg-gray-800 text-white px-3 py-2 text-base font-medium">Already have an account?</a>
</div>
@endsection