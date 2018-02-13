@extends('main')

@section('title', 'Organize event')

@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/') }}">
@endsection

@section('content')
    <h1>{{ $event->name or '' }} - Make changes</h1>
    <hr>
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <a href="{{ route('office.events.index') }}" class="btn btn-danger btn-block">Return to event management</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="content-wrapper">
                <form action="{{ route('office.events.update', $event->slug) }}" method="POST">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Event description:</label>
                                <textarea name="description" class="form-control" required="true"
                                          placeholder="Enter the event description / invitation message to pilots..."
                                          cols="30" rows="10">{{ old('description', $event->description) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="start_date">Event start date:</label>
                                <div class="input-group date">
                                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $event->start_date) }}">
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="start_time">Event start time: (in ZULU)</label>
                                <div class="input-group date">
                                    <input type="time" name="start_time" class="form-control" value="{{ old('start_time', $event->start_time) }}">
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="end_date">Event end date:</label>
                                <div class="input-group date">
                                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $event->end_date) }}">
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="end_time">Event end time: (in ZULU)</label>
                                <div class="input-group date">
                                    <input type="time" name="end_time" class="form-control" value="{{ old('end_time', $event->end_time) }}">
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-offset-4 col-md-8">
                            <button type="submit" class="btn btn-success btn-block">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection