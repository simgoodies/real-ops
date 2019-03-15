@extends('main')

@section('title')

@section('main-content')
    @include('partials._nav')

    <section class="landing-page">
        <div class="landing-page__main-heading">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="landing-page__card card text-dark text-center">
                            <div class="card-body">
                                <h1 class="display-4">VATGoodies presents Real Ops</h1>
                                <a class="btn btn-outline-primary" href="{{ route('core.pages.application') }}">I want to
                                    get started with my FIR!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="landing-page-features bg-light">
        <div class="container">
            <div class="row py-4 justify-content-center">
                <div class="col-md-8 text-dark">
                    <div class="card">
                        <div class="card-header">
                            <h2>What is the hype about?</h2>
                            <p>Well... organizing a VATSIM Real Ops event is <strong>finally within reach now</strong>!
                            </p>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-action list-group-item-secondary"><strong>Air
                                        Traffic Manager:</strong> We can finally boost our traffic levels!
                                </li>
                                <li class="list-group-item list-group-item-action list-group-item-secondary"><strong>Event
                                        Coordinator:</strong> This is exactly what I meant, but didn't know where to
                                    start!
                                </li>
                                <li class="list-group-item list-group-item-action list-group-item-secondary"><strong>Pilots:</strong>
                                    Finally some more real ops events! Whoop whoop!
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row py-2 text-center text-dark">
                <div class="col-md-4 py-2">
                    <h3><i class="fas fa-paper-plane fa-3x"></i></h3>
                    <h3 class="lead mt-3">Realistic flying operations!</h3>
                </div>
                <div class="col-md-4 py-2">
                    <h3><i class="fas fa-desktop fa-3x"></i></h3>
                    <h3 class="lead mt-3">Enhanced ATC action!</h3>
                </div>
                <div class="col-md-4 py-2">
                    <h3><i class="fas fa-globe-americas fa-3x"></i></h3>
                    <h3 class="lead mt-3">Global involvement!</h3>
                </div>
            </div>
        </div>
    </section>

    <section class="landing-page-action">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card landing-page__card bg-dark text-light">
                        <div class="card-header">
                            <h3 class="card-title">Where do I sign up?</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Are you the Air Traffic Manager of your Flight Information Region?
                                Maybe you are an events coordinator? In any case if you are somehow involved in the
                                organization of events and are looking for the next big event?</p>
                            <p class="card-text">Look no further, and sign-up your FIR to make use of Real Ops by
                                VATGoodies!</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('core.pages.application') }}" class="btn btn-primary btn-block">Sign me up
                                now...</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="landing-page-features bg-light">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <h3>What can I expect?</h3>
                        </div>
                        <div class="card-body">
                            <div class="card-deck">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Event Organization</h5>
                                        <p class="card-text">An easy to use interface that facilitates the management of
                                            your real ops event.</p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Booking System</h5>
                                        <p class="card-text">An intuitive booking system for pilots. Pilots will be able to claim their departure or arrival flight out of or into your event with ease!</p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Be a pioneer!</h5>
                                        <p class="card-text">Be part of something that is the beginning of something great! The first VATGoodies "goodie"!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="landing-page-final-cta bg-secondary">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center text-light">
                    <a class="btn btn-lg btn-primary" href="{{ route('core.pages.application') }}">I'm convinced, sign my
                        FIR up!</a>
                </div>
            </div>
        </div>
    </section>

    @include('partials._footer')

@endsection
