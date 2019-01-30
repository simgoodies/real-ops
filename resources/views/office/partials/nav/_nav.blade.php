@extends('partials._nav')

@section('nav')
    @section('nav-brand')
        <a class="navbar-brand" href="{{ route('office.index') }}">Real Ops by VATGoodies</a>
    @overwrite

    @include('partials.nav._nav')
    @yield('nav')
@overwrite