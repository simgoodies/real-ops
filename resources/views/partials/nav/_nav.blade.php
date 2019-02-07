@section('nav')
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container">

            @include('partials.nav._nav-brand')
            @yield('nav-brand')

            @include('partials.nav._nav-menu')
            @yield('nav-menu')

        </div>
    </nav>
@endsection