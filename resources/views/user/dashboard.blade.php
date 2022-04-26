@extends('layouts.dashboard')

@section('content')
<div class="flex">
    <a href="{{ url('/user/create-file') }}" class="flex-1 bg-gray-900 text-white px-3 py-2 text-base font-medium">Create</a>
    <a href="{{ url('/user/detail-file') }}" class="flex-1 bg-gray-900 text-white px-3 py-2 text-base font-medium">View</a>
</div>
@endsection