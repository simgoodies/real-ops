@extends('main')

@section('title', 'Manage bookables')

@section('main-content')
    <div class="container mx-auto">
        <div id="page-heading" class="py-4 px-6 border-b-2 border-gray-100 bg-white">
            <h1 class="text-xl">{{ $event->title }} - Manage Bookables</h1>
        </div>
        <div class="p-4 bg-gray-100">
            <img class="mx-auto max-w-full h-auto" src="https://picsum.photos/800/300" alt="Event Banner">
        </div>
    </div>

    <div class="mt-4 px-4">
        <a class="btn btn-blue block w-full " href="{{ route('bookables.index', $event) }}">Manage Bookables</a>
    </div>

    <div class="mt-4 px-4">
        <a class="btn btn-blue-secondary block w-full " href="#">Edit event details</a>
    </div>

    <div class="mt-4 px-4">
        <a class="btn btn-red-tertiary block w-full " href="#">Delete event (this action is permanent)</a>
    </div>
@endsection
