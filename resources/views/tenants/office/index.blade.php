@extends('main')

@section('title', 'Office')

@section('main-content')
    <div class="office">

        @include('tenants.partials._nav')

        @component('tenants.office.components._office-title')
            <i class="fas fa-plane mr-3 d-none d-sm-inline"></i>{{ $office_title }} - Office
        @endcomponent

    <!-- AREA SELECTOR SECTION -->
        <section class="area-selector my-3">
            <div class="container">

                <!-- AREA SELECTOR INFO ALERT -->
                <div class="alert alert-info" role="alert">
                    <h1>Welcome to your <strong>VATGoodies Real Ops</strong> office.</h1>
                    <p>From your office you will have the ability to setup your event.</p>
                    <p>Activities such as organizing an event, choosing your focus airports, adding flights, managing
                        your controllers and much more will happen from this office.</p>
                </div>
            </div>

            <!-- AREA SELECTOR CARDS -->
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card-events card bg-light">
                            <img class="area-selector__card_size card-img-top img-fluid"
                                 src="{{ asset('images/tenants/office/area-selector-events.jpeg') }}"
                                 alt="Events">
                            <div class="card-body">
                                <h5 class="card-title">Events</h5>
                                <p>Manage the details of your event(s)!</p>
                            </div>
                            <div class="card-footer text-center">
                                <a class="btn btn-outline-primary"
                                   href="{{ route('tenants.office.events.index') }}">
                                    Visit <i class="fas fa-arrow-alt-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-staff card bg-light">
                            <img class="area-selector__card_size card-img-top img-fluid"
                                 src="{{ asset('images/tenants/office/area-selector-staff-members.jpeg') }}"
                                 alt="Staff">
                            <div class="card-body">
                                <h5 class="card-title">Staff Members</h5>
                                <p>Manage the event staff members!</p>
                            </div>
                            <div class="card-footer text-center">
                                <a class="btn btn-outline-primary" href="#">Visit <i
                                            class="fas fa-arrow-alt-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>

        <!-- INCLUDE FOOTER -->
        @include('partials._footer')
    </div>
@overwrite
