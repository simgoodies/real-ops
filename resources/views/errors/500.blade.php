@extends('main')

@section('title', '404')

@section('main-content')
    <div class="503">
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="jumbotron my-0 text-center">
                        <img class="img-fluid" src="{{ asset('images/logo/main-logo.png') }}" alt="Main Logo">
                        <hr>
                        <h2>500</h2>
                        <h4>Woah, something didn't go as planned!</h4>
                        <p>This error has automatically been reported to the developers.</p>
                        <p>Feel free to send a personal message to the developers about this on <a href="https://vatgoodies.com/discord">Discord</a>  if you want to escalate this error.</p>
                    </div>
                </div>
            </div>
        </div>
        
        @include('partials._footer')
    </div>

@endsection
