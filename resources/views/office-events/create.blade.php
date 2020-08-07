@extends('main')

@section('title', 'Create an event')

@section('main-content')
    @include('partials._navigation')

    <div class="container mx-auto">
        @include('partials._page-heading', ['title' => 'Create an event'])
        <div id="page-content" class="mt-4 px-2">
            @include('partials._errors')
            <form class="mt-8" action="{{ route('office-events.store') }}" method="post">
                @csrf
                <div>
                    <label for="title">Title the event</label>
                    <input class="w-full mt-2 input" name="title" type="text">
                </div>
                <div class="mt-8 flex flex-col">
                    <label for="description">Describe the event</label>
                    <textarea class="mt-2 input" name="description" cols="20" rows="3"></textarea>
                </div>
                <div class="md:-mx-2 md:flex">
                    <div class="mt-8 flex flex-col md:px-2 md:w-1/4">
                        <label for="start_date">On what day is the event? (ZULU)</label>
                        <input class="mt-2 input" name="start_date" type="date">
                    </div>
                    <div class="mt-8 flex flex-col md:px-2 md:w-1/4">
                        <label for="start_time">At what time is the event? (ZULU)</label>
                        <input class="mt-2 input" name="start_time" type="time">
                    </div>
                </div>
                <div class="md:-mx-2 md:flex">
                    <div class="mt-8 flex flex-col md:px-2 md:w-1/4">
                        <label for="end_date">Until what day is the event? (ZULU)</label>
                        <input class="mt-2 input" name="end_date" type="date">
                    </div>
                    <div class="mt-8 flex flex-col md:px-2 md:w-1/4">
                        <label for="end_time">At what time is the event over? (ZULU)</label>
                        <input class="mt-2 input" name="end_time" type="time">
                    </div>
                </div>
                <div class="mt-8 flex justify-center md:justify-start">
                    <input class="w-5/6 md:w-1/4 btn btn-blue" type="submit" value="Create the event">
                </div>
            </form>
        </div>
    </div>
@endsection
