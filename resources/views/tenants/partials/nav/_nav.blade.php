@section('nav')
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container">
            @include('partials.nav._nav-brand')
            @yield('nav-brand')
        </div>
    </nav>
@overwrite
