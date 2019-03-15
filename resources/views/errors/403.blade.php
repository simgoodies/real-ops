@extends('main')

@section('title', '403')

@section('main-content')
    <div class="403">
        @include('partials._nav')
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="jumbotron my-0 text-center">
                        <img class="img-fluid" src="{{ asset('images/logo/main-logo.png') }}" alt="Main Logo">
                        <hr>
                        <h2>403</h2>
                        <h4>You don't seem to be authorized to be here...</h4>
                    </div>
                </div>
            </div>
        </div>
        
        @include('partials._footer')
    </div>

@endsection
