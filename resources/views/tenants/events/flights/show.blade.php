@extends('main')

@section('title', 'Office')

@section('main-content')
    <div class="office">

        @include('tenants.partials._nav')

        <div class="container">
            <div class="row my-3">
                <div class="offset-md-2 col-md-8">
                    <a href="{{ route('tenants.events.show', ['slug' => $event->slug]) }}" class="btn btn-danger btn-block">
                        Return to main event page
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h1>{{ $tenant->name }} presents</h1>
                    <h2>{{ $event->title }}</h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h3>{{ $flight->callsign }} - Flight details</h3>
                            <p><strong>Status:</strong> {{ $flight->isBooked() ? 'Booked' : 'Available for booking' }}
                            </p>
                            <p>
                                <strong>Departing from:</strong> {{ $flight->originAirport->icao }} ({{ $flight->originAirport->name }}) leaving
                                at {{ date('Hi', strtotime($flight->departure_time)) }} ZULU
                                <br>
                                <strong>Arriving at:</strong> {{ $flight->destinationAirport->icao }} ({{ $flight->destinationAirport->name }})
                                @if ($flight->aircraft_type_icao)
                                    <br>
                                    <strong>Aircraft:</strong> {{ $flight->aircraft_type_icao }}
                                @endif
                            </p>
                            @if ($flight->route)
                                <p>
                                    <strong>Route:</strong><br>
                                    {{ $flight->route }}
                                </p>
                            @endif
                        </div>

                        @if ($flight->isBooked())
                            <div class="col-md-6">
                                <h3>Cancellation form:</h3>
                                <p>If you are the pilot that has this flight booked, you can request to cancel your
                                    booking by completing the form below.</p>
                                @include('partials._messages')

                                <form action="{{ route('tenants.events.flights.bookings.cancellation-request.store', ['slug' => $event->slug, 'callsign' => $flight->callsign]) }}"
                                      method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="email">E-mail* :</label>
                                        <input type="email" name="email" class="form-control"
                                               placeholder="e.g. email@example.com"
                                               value="{{ old('email') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger btn-block">Request a cancellation...
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="col-md-6">
                                <h3>Booking form:</h3>
                                <p>If you want to book this flight, complete the form below.</p>
                                @include('partials._messages')

                                <form action="{{ route('tenants.events.flights.bookings.booking-request.store', ['slug' => $event->slug, 'callsign' => $flight->callsign]) }}"
                                      method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="vatsim_id">VATSIM ID* :</label>
                                        <input type="text" name="vatsim_id" class="form-control"
                                               placeholder="e.g. 1234567"
                                               value="{{ old('vatsim_id') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">E-mail* :</label>
                                        <input type="email" name="email" class="form-control"
                                               placeholder="e.g. email@example.com"
                                               value="{{ old('email') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-block">Request to book...
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- INCLUDE FOOTER -->
    @include('partials._footer')
@overwrite
