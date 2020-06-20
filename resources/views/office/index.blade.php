@extends('main')

@section('title', 'Office')

@section('main-content')
    <div class="container mx-auto">
        <div id="page-heading" class="py-4 px-6 border-b-2 border-gray-100 bg-white">
            <h1 class="text-xl">Office</h1>
        </div>
        <div class="p-4 bg-gray-100">
            <p>Welcome to your <strong>VATGoodies Real Ops</strong> office.</p>
            <p>From your office you will have the ability to setup your event.</p>
            <p>Activities such as organizing an event, choosing your focus airports, adding flights, managing
                your controllers and much more will happen from this office.</p>
        </div>

        <div class="mt-4 px-4">
            <a class="btn btn-blue block w-full " href="#">Manage Events</a>
        </div>

        <div class="mt-4 px-4">
            <a class="btn btn-blue-secondary block w-full " href="#">Manage staff</a>
        </div>
    </div>
@endsection
