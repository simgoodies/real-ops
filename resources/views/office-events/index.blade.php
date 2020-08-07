@extends('main')

@section('title', 'Manage Events')

@section('main-content')
    @include('partials._navigation')

    <div class="container mx-auto">
        @include('partials._page-heading', ['title' => 'Manage Events'])
        @include('partials._messages')

        <div class="mt-4 px-4">
            <a class="btn btn-blue block" href="{{ route('office-events.create') }}">Create event</a>
        </div>

        @foreach($events as $event)
            <div class="mt-4 mx-4 px-4 rounded border bg-white">
                <div class="mt-2 text-xl text-center">{{ $event->title }}</div>
                <div class="block py-4">
                    <a class="btn btn-blue-secondary block" href="{{ route('office-events.show', ['event' => $event]) }}">Manage...</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
