@extends('main')

@section('title', 'Manage Events')

@section('main-content')
    <div class="container mx-auto">
        @include('partials._page-heading', ['title' => 'Manage Events'])
        @include('partials._messages')
        @foreach($events as $event)
            <div class="mt-4 px-4">
                <div class="text-xl">{{ $event->title }}</div>
                <div class="block py-4">
                    <a class="btn btn-blue" href="{{ route('office-events.show', $event) }}">Manage...</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
