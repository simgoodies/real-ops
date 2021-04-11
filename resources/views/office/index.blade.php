@extends('main')

@section('title', 'Office')

@section('main-content')
    @include('partials._navigation')

    <div class="container mx-auto">
        @include('partials._page-heading', ['title' => 'Real Ops by simgoodies.app'])
        @include('partials._messages')

        <div>
            <div class="max-w-screen-xl px-4 py-12 mx-auto text-center sm:px-6 lg:py-16 lg:px-8">
                <h2 class="text-3xl font-extrabold leading-9 tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
                    Welcome to the {{ tenant('name') ?? '' }} office
                </h2>
            </div>
        </div>

        <div class="px-4 mt-4">
            <a class="block w-full btn btn-blue" href="{{ route('office-events.index') }}">Manage Events</a>
        </div>

        <div class="px-4 mt-4">
            <a class="block w-full btn btn-blue-secondary" href="{{ route('staff.index') }}">Manage staff</a>
        </div>
    </div>
@endsection
