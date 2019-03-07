@extends('main')

@section('title', 'Office')

@section('main-content')
    <div class="office">

        @include('tenants.partials._nav')

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{ $tenant->name }} presents</h1>
                    <h2>{{ $event->title }}</h2>
                    <hr>
                </div>
                @if ($event->banner_image_link)
                    <div class="col-md-12">
                        <div class="card">
                            <img src="{{ $event->banner_image_link }}" class="card-img-top">
                        </div>
                        <hr>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="alert alert-light">
                        <div class="card-body">
                            <h3>Event Details</h3>
                            <p class="m-0"><strong>Date:</strong> {{ date('l jS F Y', strtotime($event->start_date)) }}
                                starting
                                at {{ date('Hi', strtotime($event->start_time)) }} ZULU ending
                                at {{ date('Hi', strtotime($event->end_time)) }} ZULU
                            </p>
                            @if ($event->description)
                                <p class="m-0">
                                    <strong>Description:</strong><br>
                                    {{ $event->description }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="col-md-12 d-none d-md-block">
                    <h3>Flights to book for {{ $event->title }}</h3>
                    @forelse($flights as $flight)
                        @if ($loop->first)
                            <table class="table table-sm table-light text-center">
                                <thead>
                                <tr>
                                    <th scope="col">Callsign</th>
                                    <th scope="col">Departure Time:</th>
                                    <th scope="col">Departing From:</th>
                                    <th scope="col">Arriving At:</th>
                                    <th scope="col">Book:</th>
                                </tr>
                                </thead>
                                <tbody>
                                @endif
                                <tr>
                                    <td class="align-middle">{{ $flight->callsign }}</td>
                                    <td class="align-middle">{{ date('Hi', strtotime($flight->departure_time)) }}Z</td>
                                    <td class="align-middle">{{ $flight->origin_airport_icao }}</td>
                                    <td class="align-middle">{{ $flight->destination_airport_icao }}</td>
                                    <td class="align-middle">
                                        @if ($flight->isBooked())
                                            <a href="{{ route('tenants.events.flights.show', ['slug' => $event->slug, 'callsign' => $flight->callsign]) }}"
                                               class="btn btn-danger btn-block btn-sm">BOOKED (cancel booking?)</a>
                                        @else
                                            <a href="{{ route('tenants.events.flights.show', ['slug' => $event->slug, 'callsign' => $flight->callsign]) }}"
                                               class="btn btn-info btn-block btn-sm">Book flight...</a>
                                        @endif
                                    </td>
                                </tr>
                                @if ($loop->last)
                                </tbody>
                            </table>
                        @endif
                    @empty
                        <p>There are no flights for this event yet.</p>
                    @endforelse
                </div>
                <div class="col-md-12 d-block d-md-none">
                    <h3>Flights to book for {{ $event->title }}</h3>
                    @forelse($flights as $flight)
                        @if ($loop->first)
                            <div class="row">
                                @endif
                                <div class="col-12 my-1">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p class="my-0"><strong>Callsign:</strong> {{ $flight->callsign }}
                                                    </p>
                                                </div>
                                                <div class="col-md-12">
                                                    <p class="my-0"><strong>Departure
                                                            From:</strong> {{ $flight->origin_airport_icao }}
                                                        at {{ date('Hi', strtotime($flight->departure_time)) }}Z</p>
                                                </div>
                                                <div class="col-md-12">
                                                    <p class="my-0"><strong>Arriving
                                                            At:</strong> {{ $flight->destination_airport_icao }}
                                                        at {{ date('Hi', strtotime($flight->arrival_time)) }}Z</p>
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    @if ($flight->isBooked())
                                                        <a href="#" class="btn btn-danger btn-block btn-sm">BOOKED
                                                            (cancel booking?)</a>
                                                    @else
                                                        <a href="#" class="btn btn-info btn-block btn-sm">Book
                                                            flight...</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($loop->last)
                            </div>
                        @endif
                    @empty
                        <p>There are no flights for this event yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- INCLUDE FOOTER -->
    @include('partials._footer')
    </div>
@overwrite
