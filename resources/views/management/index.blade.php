@extends('main')

@section('title', 'Management')

@section('main-content')
    <div class="management">

        <!-- INCLUDE OFFICE NAV -->
    @include('partials._nav')

    <!-- OFFICE TITLE SECTION -->
        <section class="management-title bg-secondary py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Management - Dashboard</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- AREA SELECTOR SECTION -->
        <section class="area-selector my-3">

            <!-- AREA SELECTOR CARDS -->
            <div class="container">
                <div class="card-deck text-center">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Tenants</h5>
                            <p>Manage tenants here</p>
                        </div>
                        <div class="card-footer">
                            <a class="btn btn-outline-primary" href="{{ route('management.tenants.index') }}">Visit <i
                                        class="fas fa-arrow-alt-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Applications</h5>
                            <p>Manage applications here</p>
                        </div>
                        <div class="card-footer">
                            <a class="btn btn-outline-primary" href="#">Visit <i
                                        class="fas fa-arrow-alt-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Lorem Ipsum</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur.</p>
                        </div>
                        <div class="card-footer">
                            <a class="btn btn-outline-primary" href="#">Visit <i
                                        class="fas fa-arrow-alt-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- INCLUDE FOOTER -->
        @include('partials._footer')
    </div>
@overwrite