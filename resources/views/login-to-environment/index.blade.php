@extends('main')

@section('title', 'Login to Environment')

@section('main-content')
    <a href="{{ route('setup-environment.show') }}">Setup Environment</a>
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <input type="submit" value="Logout">
    </form>

    @foreach($domains as $domain)
        <form action="{{ route('login-to-environment.store') }}" method="post">
            @csrf
            <input name="subdomain" type="text" value="{{$domain->domain}}" readonly>
            <input type="submit">
        </form>
    @endforeach
@endsection
