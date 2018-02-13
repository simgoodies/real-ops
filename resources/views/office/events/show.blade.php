@extends('main')

@section('title', $event->name)

@section('content')
    <div class="office-event-show">
        <h1>{{ $event->name or '' }}</h1>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('office.events.index') }}" class="btn btn-danger btn-block">Return to events</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <img src="https://loremflickr.com/2000/500" alt=""
                     class="img-responsive event-banner-image">
            </div>
        </div>

        <div class="content-wrapper">
            <div class="row event-office-buttons">
                <div class="col-md-6">
                    <a href="{{ route('office.events.edit', ['slug' => $event->slug]) }}" class="btn btn-info btn-block">Change event details</a>
                </div>
                <div class="col-md-6">
                    <a href="#" class="btn btn-info btn-block">Manage focus airports</a>
                </div>
                <div class="col-md-6">
                    <a href="#" class="btn btn-info btn-block">Manage flights</a>
                </div>
                <div class="col-md-6">
                    <a href="#" class="btn btn-info btn-block">Some other stuff.....</a>
                </div>
            </div>
        </div>
    </div>
@endsection