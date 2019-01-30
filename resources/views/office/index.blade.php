@extends('main')

@section('title', 'Office')

@section('main-content')
    <div class="office">
            @include('office.partials.nav._nav')
        <h1>[Hakuna Matata FIR] Real Ops - Office</h1>
        <hr>
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                            Welcome to your VATGoodies Real Ops office. It is from this location that you can setup your
                            event. Activities such as organizing an event, choosing your focus airports, adding flights,
                            managing your controllers and much more will happen from this office.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('office.events.index') }}">
                    <div class="panel panel-default">
                        <div class="panel-image">
                            <img src="https://loremflickr.com/400/400" alt="" class="img-responsive office-image">
                        </div>
                        <div class="panel-footer">
                            <h4>Events</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-image">
                        <img src="https://loremflickr.com/400/400" alt="" class="img-responsive office-image">
                    </div>
                    <div class="panel-footer">
                        <h4>Assistants</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@overwrite