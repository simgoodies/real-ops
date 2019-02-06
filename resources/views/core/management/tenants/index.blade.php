@extends('main')

@section('title', 'Management - Tenants')

@section('main-content')
    <div class="management-tenants">

        <!-- INCLUDE OFFICE NAV -->
    @include('partials._nav')

    <!-- OFFICE TITLE SECTION -->
        <section class="management-tenants-title bg-secondary py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Management - Tenants</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- TABLE LIST OF TENANTS -->
        <section id="tenants" class="my-4">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tenants</h4>
                            </div>
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>San Juan FIR</td>
                                    <td>May 10 2018</td>
                                    <td>
                                        <a href="#" class="btn btn-secondary">
                                            <i class="fas fa-angle-double-right"></i> Details
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Piarco FIR</td>
                                    <td>May 11 2018</td>
                                    <td>
                                        <a href="#" class="btn btn-secondary">
                                            <i class="fas fa-angle-double-right"></i> Details
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- INCLUDE FOOTER -->
        @include('partials._footer')
    </div>
@overwrite