@extends('main')

@section('title', 'Create an event')

@section('main-content')
    <div class="container mx-auto">
        @include('partials._page-heading', ['title' => $event->title])
        <div class="p-4 bg-gray-100">
            <img class="mx-auto max-w-full h-auto" src="{{ $event->banner_url }}" alt="Event Banner">
        </div>
        <div class="mt-4 px-4">
            {{ $event->description }}
        </div>
        <div class="mt-4 px-4">
            @livewire('display-bookables', ['event' => $event])
        </div>
    </div>
@endsection
