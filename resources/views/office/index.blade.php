@extends('main')

@section('title', 'Office')

@section('main-content')
    <div class="container mx-auto">
        @include('partials._page-heading', ['title' => 'Office'])
        <div class="p-4 bg-gray-100">
            <p>Welcome to your <strong>VATGoodies Real Ops</strong> office.</p>
            <p>From your office you will have the ability to setup your event.</p>
            <p>Activities such as organizing an event, choosing your focus airports, adding flights, managing
                your controllers and much more will happen from this office.</p>
        </div>

        <div class="mt-4 px-4">
            <a class="btn btn-blue block w-full " href="{{ tenant_path_route('office-events.index') }}">Manage Events</a>
        </div>

        <div class="mt-4 px-4">
            <a class="btn btn-blue-secondary block w-full " href="#">Manage staff</a>
        </div>
    </div>
@endsection
