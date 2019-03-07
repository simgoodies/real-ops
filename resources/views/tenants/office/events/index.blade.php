@extends('main')

@section('title', 'Events')

@section('main-content')

    @include('tenants.partials._nav')

    @component('tenants.office.components._office-title')
        {{ $tenant->name }} - Event Management
    @endcomponent

    <div class="container">
        <div class="row my-3">
            <div class="col-md-6">
                <a href="{{ route('tenants.office.index') }}" class="btn btn-danger btn-block">
                    Return to office
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('tenants.office.events.create') }}" class="btn btn-success btn-block">
                    Organize new event!
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @forelse($events as $event)
                    <div class="card my-3">
                        <div class="card-header bg-light">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4>{{ $event->title }}</h4>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('tenants.office.events.show', ['slug' => $event->slug]) }}"
                                       class="btn btn-outline-primary btn-block">
                                        Manage <i class="fas fa-arrow-alt-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @if ($event->banner_image_link)
                            <div class="card-body mx-auto p-0">
                                <img src="{{ $event->banner_image_link }}"
                                     class="img-fluid">
                            </div>
                        @else
                            <div class="card-body">
                                <p class="card-text"><strong>Event Description:</strong> {{ $event->description }}</p>
                                <p class="card-text"><strong>Event Start Date and Time:</strong> {{ date('l jS F Y', strtotime($event->start_date)) }} at {{ date('Hi', strtotime($event->start_time)) }} ZULU</p>
                                <p class="card-text"><strong>Event End Date and Time:</strong> {{ date('l jS F Y', strtotime($event->end_date)) }} at {{ date('Hi', strtotime($event->end_time)) }} ZULU</p>
                            </div>
                        @endif
                    </div>
                @empty
                    <h5>There are no organized events as this time.</h5>
                @endforelse
            </div>
        </div>
    </div>
@endsection
