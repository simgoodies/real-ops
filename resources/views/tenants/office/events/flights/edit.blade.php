@extends('main')

@section('title', $event->title)

@section('main-content')

    @include('tenants.office.partials._nav')

    @component('tenants.office.components._office-title')
        {{ $tenant->name }} - {{ $event->title }} - {{ $flight->callsign }}
    @endcomponent

    <div class="container">
        <div class="row my-3">
            <div class="offset-md-2 col-md-8">
                <a href="{{ route('tenants.office.events.flights.index', ['slug' => $event->slug]) }}" class="btn btn-danger btn-block">
                    Return to flights of {{ $event->title }}
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Edit flight...</h3>

                @include('partials._errors')

                <form action="{{ route('tenants.office.events.flights.update', ['slug' => $event->slug, 'callsign' => $flight->callsign]) }}" method="post">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group">
                            <label for="event_id" class="sr-only">event_id</label>
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                        </div>
                        <div class="form-group col-lg-2 col-md-4">
                            <label for="callsign">Callsign* :</label>
                            <input type="text" name="callsign" class="form-control" placeholder="e.g. AAL123"
                                   value="{{ old('callsign', $flight->callsign) }}" required readonly>
                        </div>
                        <div class="form-group col-lg-3 col-md-4">
                            <label for="origin_airport_icao">Origin Airport ICAO* :</label>
                            <input type="text" name="origin_airport_icao" class="form-control" placeholder="e.g. KMIA"
                                   value="{{ old('origin_airport_icao', $flight->origin_airport_icao) }}" required>
                        </div>
                        <div class="form-group col-lg-3 col-md-4">
                            <label for="destination_airport_icao">Destination Airport ICAO* :</label>
                            <input type="text" name="destination_airport_icao" class="form-control"
                                   placeholder="e.g. TJSJ" value="{{ old('destination_airport_icao', $flight->destination_airport_icao) }}" required>
                        </div>
                        <div class="form-group col-lg-2 col-md-6">
                            <label for="departure_time">Departure Time* :</label>
                            <input type="time" name="departure_time" class="form-control"
                                   value="{{ old('departure_time', $flight->departure_time) }}" required>
                        </div>
                        <div class="form-group col-lg-2 col-md-6">
                            <label for="arrival_time">Arrival Time* :</label>
                            <input type="time" name="arrival_time" class="form-control"
                                   value="{{ old('arrival_time', $flight->arrival_time) }}" required>
                        </div>
                        <div class="form-group col-lg-10 col-md-9">
                            <label for="route">Preferred Route:</label>
                            <input type="text" name="route" class="form-control"
                                   placeholder="e.g. KMIA WOOZE BR53V RAJAY A555 IDAHO TJSJ" value="{{ old('route', $flight->route) }}">
                        </div>
                        <div class="form-group col-lg-2 col-md-3">
                            <label for="aircraft_type_icao">Aircraft Type ICAO:</label>
                            <input type="text" name="aircraft_type_icao" class="form-control" placeholder="e.g. B734"
                                   value="{{ old('aircraft_type_icao', $flight->aircraft_type_icao) }}">
                        </div>
                        <div class="form-group col-lg-3 col-md-5 ml-auto">
                            <button type="submit" class="btn btn-success btn-block">Update flight</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
