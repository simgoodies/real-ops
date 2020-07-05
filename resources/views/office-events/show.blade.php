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
                <a class="btn btn-blue-secondary block w-full " href="#">Edit event details</a>
            </div>
        </div>
        <div class="mt-4 px-4">
            <a class="btn btn-red-tertiary block w-full " href="#">Delete event (this action is permanent)</a>
        </div>
        <div class="mt-4 px-4">
            <h2 class="text-lg">Bookables actions</h2>
            <hr class="mt-2">
        </div>
        <div x-data="{ bookable: 'none'}">
            <div x-show="bookable === 'none'" class="mt-4 px-4 md:px-4 w-1/2">
                <button class="btn btn-blue block w-full " @click="bookable = 'flight'">Add flight</button>
            </div>
            <div x-show="bookable !== 'none'" class="mt-4 px-4 md:px-4 w-full">
                <button class="btn btn-blue-secondary block w-full " @click="bookable = 'none'">Cancel</button>
            </div>
            <div class="mt-4 px-4">
                <div x-show.transition.duration.1000ms="bookable === 'flight'">
                    @livewire('add-bookable-flight', ['event' => $event])
                </div>
            </div>
        </div>
    </div>
@endsection
