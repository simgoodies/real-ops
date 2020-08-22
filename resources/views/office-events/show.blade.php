@extends('main')

@section('title', 'Event Details')

@section('main-content')
    @include('partials._navigation')

    <div class="container mx-auto">
        @include('partials._page-heading', ['title' => $event->title . ' - Event Details'])
        <div class="p-4 bg-gray-100">
            @if($event->banner_url)
                <img class="mx-auto max-w-full h-auto" src="{{ $event->banner_url }}" alt="Event Banner">
            @else
                <p>No Event Banner...</p>
            @endif
        </div>

        <div class="mt-4 px-4">
            @include('partials._messages')
        </div>

        <div class="mt-4 px-4">
            <h2 class="text-lg">Event actions</h2>
            <hr class="mt-2">
        </div>

        <div x-data="{ editOpen: false }"
            class="px-4">
            <div x-show="!editOpen" class="md:flex md:flex-wrap md:-mx-2">
                <div class="mt-4 w-full md:px-2 md:w-1/2">
                    <button class="btn btn-blue w-full" @click="editOpen = true">Edit event details</button>
                </div>
                <div x-data="{ showDeleteConfirm: false }" class="mt-4 w-full md:px-2 md:w-1/2">
                    @if(session()->has('event-delete-failure'))
                        <div class="mb-4 p-2 bg-red-200 text-red-800 border-2 border-red-700">
                            {{ session()->get('event-delete-failure') }}
                        </div>
                    @endif
                    <button x-show="!showDeleteConfirm" @click="showDeleteConfirm = true" class="btn btn-red-secondary block w-full" href="#">Delete event (this action is permanent)</button>
                    <button x-show="showDeleteConfirm" @click="showDeleteConfirm = false" class="btn btn-blue-secondary w-full">Cancel (keep event)</button>
                    <form x-show="showDeleteConfirm" class="mt-4" action="{{ route('office-events.destroy', ['event' => $event]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="text" class="input w-full" name="confirmText" placeholder="type this sentence, 'this is intentional!'" required>
                        <button type="submit" class="mt-4 btn btn-red w-full">I am sure!</button>
                    </form>
                </div>
                <div class="mt-4 -mx-2 flex md:px-2 md:w-full">
                    <div class="w-3/4 relative px-2">
                        <input class="input w-full h-full" type="text" readonly value="{{ route('events.show', ['event' => $event]) }}" style="padding-left: 6.5rem">
                        <div class="rounded-tl rounded-bl border-tl border-bl shadow-tl shadow-bl bg-blue-200 absolute inset-y-0 pt-2 px-4">
                            event url:
                        </div>
                    </div>
                    <div class="w-1/4 px-2">
                        <a href="{{ route('events.show', ['event' => $event]) }}" target="_blank">
                            <button class="btn btn-blue-secondary w-full">
                                Visit
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-4 w-full">
                <div x-show="editOpen">
                    <button @click="editOpen = false" class="w-full block btn btn-blue-secondary lg:w-1/3 lg:mx-auto">Cancel</button>
                    @livewire('edit-event', ['event' => $event])
                </div>
            </div>
        </div>
        <div class="mt-4 px-4">
            <h2 class="text-lg">Bookables actions</h2>
            <hr class="mt-2">
        </div>
        @if($event->bookable_type)
            <div x-data="{ openBookableAction: 'none'}">
                <div class="flex">
                    <div x-show="openBookableAction === 'none'" class="mt-4 px-4 md:px-4 w-1/2">
                        <button class="btn btn-blue w-full" @click="openBookableAction = 'addFlight'">Add flight</button>
                    </div>
                    <div x-show="openBookableAction === 'none'" class="mt-4 px-4 md:px-4 w-1/2">
                        <button class="btn btn-blue-secondary w-full" @click="openBookableAction = 'importFlights'">Import Flights</button>
                    </div>
                </div>
                <div x-show="openBookableAction !== 'none'" class="mt-4 px-4 md:px-4 w-full">
                    <button class="btn btn-blue-secondary w-full " @click="openBookableAction = 'none'">Cancel</button>
                </div>
                <div x-show.transition.duration.300ms="openBookableAction === 'addFlight'" class="mt-4 px-4">
                    @livewire('add-bookable-flight', ['event' => $event])
                </div>
                <div x-show.transition.duration.300ms="openBookableAction === 'importFlights'" class="mt-4 px-4">
                    @livewire('bookable-flight-import', ['event' => $event])
                </div>
            </div>
            <div class="mt-4 px-4">
                @livewire('office-display-bookables', ['event' => $event])
            </div>
        @else
            <div class="mt-4 px-4">
                <p class="text-center font-semibold text-xl">Choose Event Bookable Type</p>
                @livewire('choose-event-bookable-type', ['event' => $event])
            </div>
        @endif
    </div>
@endsection
