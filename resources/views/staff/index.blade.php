@extends('main')

@section('title', 'Staff')

@section('main-content')
    @include('partials._navigation')

    <div class="container mx-auto">
        @include('partials._page-heading', ['title' => 'Manage Staff'])

        <div id="page-content" class="px-2 mt-4">
            @include('partials._messages')
            <div class="px-4 mt-4">
                <h2 class="text-lg">Invite a new staff member to {{ tenant('name') ?? 'the environment' }}.</h2>
                <hr class="mt-2">

                @include('partials._errors')
                <form class="mt-4" action="{{ route('staff-invite.store') }}" method="post">
                    @csrf
                    <div>
                        <label for="email">E-mail</label>
                        <input class="w-full mt-2 input" name="email" type="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="mt-4">
                        <input class="w-full btn btn-blue" type="submit" value="Send invitation e-mail">
                    </div>
                </form>
            </div>
            <div class="px-4 mt-4">
                <h2 class="text-lg">Members of {{ tenant('name') }}.</h2>
                <hr class="mt-2">
                <div class="mt-4">
                    @foreach($staff as $member)
                        <div class="pl-4 mt-2">
                            {{ $member->email }}
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection
