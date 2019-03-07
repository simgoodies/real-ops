@extends('main')

@section('title', 'Flights')

@section('main-content')

    @include('tenants.partials._nav')

    @component('tenants.office.components._office-title')
        {{ $tenant->name }} - {{ $event->title }} - Flights
    @endcomponent

    <div class="container">

        <div class="row mt-3">
            <div class="col-md-12">
                <h3>Add a flight...</h3>

                @include('partials._errors')
                @include('partials._messages')

                <form action="{{ route('tenants.office.events.flights.store', ['slug' => $event->slug]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group">
                            <label for="event_id" class="sr-only">event_id</label>
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                        </div>
                        <div class="form-group col-lg-2 col-md-4">
                            <label for="callsign">Callsign* :</label>
                            <input type="text" name="callsign" class="form-control" placeholder="e.g. AAL123"
                                   value="{{ old('callsign') }}" required>
                        </div>
                        <div class="form-group col-lg-3 col-md-4">
                            <label for="origin_airport_icao">Origin Airport ICAO* :</label>
                            <input type="text" name="origin_airport_icao" class="form-control" placeholder="e.g. KMIA"
                                   value="{{ old('origin_airport_icao') }}" required>
                        </div>
                        <div class="form-group col-lg-3 col-md-4">
                            <label for="destination_airport_icao">Destination Airport ICAO* :</label>
                            <input type="text" name="destination_airport_icao" class="form-control"
                                   placeholder="e.g. TJSJ" value="{{ old('destination_airport_icao') }}" required>
                        </div>
                        <div class="form-group col-lg-2 col-md-6">
                            <label for="departure_time">Departure Time* :</label>
                            <input type="time" name="departure_time" class="form-control"
                                   value="{{ old('departure_time') }}" required>
                        </div>
                        <div class="form-group col-lg-2 col-md-6">
                            <label for="arrival_time">Arrival Time* :</label>
                            <input type="time" name="arrival_time" class="form-control"
                                   value="{{ old('arrival_time') }}" required>
                        </div>
                        <div class="form-group col-lg-10 col-md-9">
                            <label for="route">Preferred Route:</label>
                            <input type="text" name="route" class="form-control"
                                   placeholder="e.g. KMIA WOOZE BR53V RAJAY A555 IDAHO TJSJ" value="{{ old('route') }}">
                        </div>
                        <div class="form-group col-lg-2 col-md-3">
                            <label for="aircraft_type_icao">Aircraft Type ICAO:</label>
                            <input type="text" name="aircraft_type_icao" class="form-control" placeholder="e.g. B734"
                                   value="{{ old('aircraft_type_icao') }}">
                        </div>
                        <div class="form-group col-lg-3 col-md-5 ml-auto">
                            <button type="submit" class="btn btn-success btn-block">Add flight</button>
                        </div>
                    </div>
                </form>
                <hr>
                @forelse($flights as $flight)
                    @if ($loop->first)
                        <h3>Flights for {{ $event->title }}</h3>
                        {{ $flights->links() }}
                        <div class="row">
                    @endif
                            <div class="col-lg-3 col-md-4 col-sm-6 my-2">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="my-1"><strong>Callsign:</strong> {{ $flight->callsign }}</p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="my-1"><strong>From:</strong> {{ $flight->origin_airport_icao }} at {{ date('Hi', strtotime($flight->departure_time)) }}Z</p>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="my-1"><strong>To:</strong> {{ $flight->destination_airport_icao }} at {{ date('Hi', strtotime($flight->arrival_time)) }}Z</p>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <a href="{{ route('tenants.office.events.flights.edit', ['slug' => $event->slug, 'callsign' => $flight->callsign]) }}" class="btn btn-outline-info btn-block">Edit</a>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <form action="{{ route('tenants.office.events.flights.destroy', ['slug' => $event->slug, 'callsign' => $flight->callsign]) }}" method="post"
                                                              onsubmit="return confirm('Are you sure you want to permanently delete this flight? This action cannot be undone.')">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <button class="btn btn-outline-danger btn-block" type="submit">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @if ($loop->last)
                        </div>
                        {{ $flights->links() }}
                    @endif
                @empty
                    <h3>There are no flights for this event yet.</h3>
                @endforelse
            </div>
        </div>
    </div>
@endsection
