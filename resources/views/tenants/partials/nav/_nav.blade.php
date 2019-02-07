@section('nav')
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container">

            @include('partials.nav._nav-brand')
            @yield('nav-brand')

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item {{ Request::segment(1) == null ? 'active' : '' }}">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item {{ Request::segment(1) == 'office' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('tenants.office.index') }}">Office</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@overwrite