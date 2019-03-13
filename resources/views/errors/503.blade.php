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
                        <h2>503</h2>
                        <h4>We are temporarily unavailable...</h4>
                        <p>Maybe we are deploying a new release?<br>
                        Maybe we are fixing a bug somewhere?</p>
                        <p>Check back again later we'll probably be back soon.</p>
                    </div>
                </div>
            </div>
        </div>
        
        @include('partials._footer')
    </div>

@endsection
