@section('nav-menu')
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ Request::segment(1) == null ? 'active' : '' }}">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item {{ Request::segment(1) == 'apply' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('core.pages.application') }}">Apply now</a>
            </li>
            <li class="nav-item {{ Request::segment(1) == 'contact' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('core.pages.contact') }}">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://www.vatgoodies.com" target="_blank">Visit VATGoodies.com</a>
            </li>
        </ul>
    </div>
@endsection