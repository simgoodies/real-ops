@extends('main')

@section('title', 'Manage bookables')

@section('main-content')
    <div class="container mx-auto">
        @include('partials._page-heading', ['title' => $event->title . ' - Manage Bookables'])
        <div class="p-4 bg-gray-100">
            <img class="mx-auto max-w-full h-auto" src="https://picsum.photos/800/300" alt="Event Banner">
        </div>
    </div>
@endsection
