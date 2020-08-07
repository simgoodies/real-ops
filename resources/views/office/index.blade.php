@extends('main')

@section('title', 'Office')

@section('main-content')
    @include('partials._navigation')

    <div class="container mx-auto">
        @include('partials._page-heading', ['title' => 'Office'])
        <div class="p-4 bg-gray-100">
            <p>Welcome to your <strong>VATGoodies Real Ops</strong> office.</p>
            <p>From your office you will have the ability to setup your event.</p>
            <p>Activities such as organizing an event, choosing your focus airports, adding flights, managing
                your controllers and much more will happen from this office.</p>
        </div>

        <div class="mt-4 px-4">
            <a class="btn btn-blue block w-full " href="{{ route('office-events.index') }}">Manage Events</a>
        </div>

        <div class="mt-4 px-4">
            <a class="btn btn-blue-secondary block w-full opacity-25" href="#">Manage staff (coming soon)</a>
        </div>
    </div>
@endsection
