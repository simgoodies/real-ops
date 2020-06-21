@extends('main')

@section('title', 'Create an event')

@section('main-content')
    <div class="container mx-auto">
        @include('partials._page-heading', ['title' => $event->title . ' - Event Details'])
        <div class="p-4 bg-gray-100">
            <img class="mx-auto max-w-full h-auto" src="https://picsum.photos/800/300" alt="Event Banner">
        </div>
        <div class="mt-4 px-4">
            <h2 class="text-lg">Event actions</h2>
            <hr class="mt-2">
        </div>
        <div class="md:flex">
            <div class="mt-4 px-4 md:px-4 md:w-1/2">
                <a class="btn btn-blue block w-full" href="{{ route('bookables.index', $event) }}">Manage Bookables</a>
            </div>
            <div class="mt-4 px-4 md:px-4 md:w-1/2">
                <a class="btn btn-blue-secondary block w-full " href="#">Edit event details</a>
            </div>
        </div>
        <div class="mt-4 px-4">
            <a class="btn btn-red-tertiary block w-full " href="#">Delete event (this action is permanent)</a>
        </div>
    </div>
@endsection
