@extends('main')

@section('title', 'Staff Management')

@section('main-content')

    @include('tenants.office.partials._nav')

    @component('tenants.office.components._office-title')
        {{ $tenant->name }} - Staff Management
    @endcomponent

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row my-3">
                    <div class="col-md-6">
                        <a href="{{ route('tenants.office.index') }}" class="btn btn-danger btn-block">
                            Return to office
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('tenants.office.events.create') }}" class="btn btn-success btn-block">
                            Add new staff member
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        @include('partials._messages')

        <div class="row">
            <div class="col-md-12">
                <h3>Invite staff members into {{ $tenant->name }} Real Ops</h3>
                <form action="{{ route('tenants.office.staff-management-users.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Name:</span>
                                    </div>
                                    <input type="text" class="form-control" name="name" placeholder="e.g. John Doe">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Email:</span>
                                    </div>
                                    <input type="email" class="form-control" name="email" placeholder="e.g. johndoe@example.com">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button class="btn btn-block btn-info" type="submit">Send invitation</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @foreach($users as $user)
                <div class="col-md-4">
                    <div class="card my-2">
                        <div class="card-header">
                            {{ $user->name }}
                        </div>
                        <div class="card-body">
                            @foreach($roles as $role)
                                @if ($user->hasRole($role->name))
                                    <form action="{{ route('tenants.office.staff-management-roles.destroy') }}" method="post">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="user_id" class="sr-only">user_id</label>
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <label for="role_id" class="sr-only">role_id</label>
                                            <input type="hidden" name="role_id" value="{{ $role->id }}">
                                            <input type="submit" class="btn btn-sm btn-danger btn-block" value="Remove Role: {{ $role->name }}">
                                        </div>
                                    </form>
                                @else
                                    <form action="{{ route('tenants.office.staff-management-roles.store') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="user_id" class="sr-only">user_id</label>
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <label for="role_id" class="sr-only">role_id</label>
                                            <input type="hidden" name="role_id" value="{{ $role->id }}">
                                            <input type="submit" class="btn btn-sm btn-success btn-block" value="Assign Role: {{ $role->name }}">
                                        </div>
                                    </form>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('partials._footer')
@endsection
