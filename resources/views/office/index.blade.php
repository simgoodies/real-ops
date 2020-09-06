@extends('main')

@section('title', 'Office')

@section('main-content')
    @include('partials._navigation')

    <div class="container mx-auto">
        @include('partials._page-heading', ['title' => 'Real Ops by simgoodies.app'])
        <div>
            <div class="max-w-screen-xl mx-auto text-center py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
                <h2 class="text-3xl leading-9 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
                    Welcome to the {{ tenant('name') ?? '' }} office
                </h2>
            </div>
        </div>

        <div class="mt-4 px-4">
            <a class="btn btn-blue block w-full" href="{{ route('office-events.index') }}">Manage Events</a>
        </div>

        <div class="mt-4 px-4">
            <a class="btn btn-blue-secondary block w-full" href="{{ route('staff.index') }}">Manage staff</a>
        </div>
    </div>
@endsection
