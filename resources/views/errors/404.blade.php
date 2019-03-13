@extends('main')

@section('title', '404')

@section('main-content')
    <div class="404">
        @include('partials._nav')
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="jumbotron my-0 text-center">
                        <img class="img-fluid" src="{{ asset('images/logo/main-logo.png') }}" alt="Main Logo">
                        <hr>
                        <h2>404</h2>
                        <h4>We can't seem to find the page you are looking for...</h4>
                    </div>
                </div>
            </div>
        </div>
        
        @include('partials._footer')
    </div>

@endsection
