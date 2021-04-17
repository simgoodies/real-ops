@extends('main')

@section('title', 'Login to Environment')

@section('main-content')
    <div class="mt-12 sm:mt-16 lg:mt-0 lg:col-span-6">
        <div class="sm:max-w-md sm:w-full sm:mx-auto sm:rounded-lg sm:overflow-hidden">
            <div class="px-4 py-8 sm:px-10">
                <div>
                    <img class="w-auto h-12 mx-auto" src="images/favicon/android-chrome-512x512.png" alt="Simgoodies Logo">
                    <h2 class="mt-6 text-2xl font-extrabold leading-9 text-center text-gray-900">
                        Login to your environment
                    </h2>
                </div>
                @include('partials._messages')

                <div class="px-4 py-6 mt-8 bg-white border rounded-lg flex-column">
                    <div class="flex -mx-2">
                        <a href="{{ route('setup-environment.show') }}" class="w-2/3 px-2">
                            <button class="w-full px-1 btn btn-blue-secondary">
                                Create Environment
                            </button>
                        </a>

                        <form class="w-1/3 px-2" action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="w-full px-1 btn btn-blue-tertiary">
                                Logout
                            </button>
                        </form>
                    </div>

                    @if($domains->isNotEmpty())
                        <div class="mx-4 mt-6 border border-b-4 border-gray-100"></div>
                    @endif
                    <div>
                        @foreach($domains as $domain)
                            <form class="mt-4 ml-auto" action="{{ route('login-to-environment.store') }}" method="post">
                                @csrf
                                <input name="subdomain" type="hidden" value="{{$domain->domain}}" readonly>
                                <input class="w-full btn btn-blue" type="submit" value="Login to {{ $domain->tenant->name }} ({{ $domain->domain }})">
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
