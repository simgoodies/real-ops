@extends('main')

@section('title', 'Create an event')

@section('main-content')
    <div class="container mx-auto">
        <div id="page-heading" class="py-4 px-6 border-b-2 border-gray-100 bg-white">
            <h1 class="text-3xl">{{ $event->title }}</h1>
        </div>
        <div id="page-content" class="mt-4">
            This is the event show page
        </div>
    </div>
@endsection
