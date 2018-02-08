@extends('main')

@section('title', 'Events')

@section('content')
    <h1>Event Management</h1>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('office.index') }}" class="btn btn-danger btn-block">Return to office</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('events.create') }}" class="btn btn-success btn-block">Organize new event!</a>
        </div>
    </div>
    <div class="content-wrapper">
        <table class="table table-hover event">
            <thead>
            <tr>
                <th>Event Name</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Hakuna Matata Event</td>
                <td></td>
            </tr>
            <tr>
                <td>Hakuna Getaway</td>
                <td></td>
            </tr>
            <tr>
                <td>Caribbean Real Ops</td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection