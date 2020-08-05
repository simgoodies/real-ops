@extends('main')

@section('title', 'Register')

@section('main-content')
    <form action="{{ route('setup-environment.store') }}" method="post">
        @csrf
        <input name="name" type="text" placeholder="Name">
        <input name="subdomain" type="text" placeholder="my-subdomain">
        <input type="submit">
    </form>
@endsection
