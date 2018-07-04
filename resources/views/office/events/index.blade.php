@extends('main')

@section('title', 'Events')

@section('content')
    <h1>Event Management</h1>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('office.index') }}" class="btn btn-danger btn-block">Return to office</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('office.events.create') }}" class="btn btn-success btn-block">Organize new event!</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="panel-group event-panel-group">
                @foreach($events as $event)
                    <div class="panel event-panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4>{{ $event->title }}</h4>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('office.events.show', ['slug' => $event->slug]) }}"
                                       class="btn btn-default btn-block">Manage</a>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body event-banner">
                            <div class="panel-image">
                                <img src="https://loremflickr.com/1000/400" alt=""
                                     class="img-responsive event-banner-image">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection