@extends('main')

@section('title', 'Login to Environment')

@section('main-content')
    <div class="mt-12 sm:mt-16 lg:mt-0 lg:col-span-6">
        <div class="sm:max-w-md sm:w-full sm:mx-auto sm:rounded-lg sm:overflow-hidden">
            <div class="px-4 py-8 sm:px-10">
                <div>
                    <img class="mx-auto h-12 w-auto" src="images/favicon/android-chrome-512x512.png" alt="Simgoodies Logo">
                    <h2 class="mt-6 text-center text-2xl leading-9 font-extrabold text-gray-900">
                        Login to your environment
                    </h2>
                </div>
                <div class="mt-8 py-6 px-4 flex-column border rounded-lg bg-white">
                    <div class="flex -mx-2">
                        <a href="{{ route('setup-environment.show') }}" class="px-2 w-2/3">
                            <button class="px-1 w-full btn btn-blue-secondary">
                                Create Environment
                            </button>
                        </a>

                        <form class="px-2 w-1/3" action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="px-1 w-full btn btn-blue-tertiary">
                                Logout
                            </button>
                        </form>
                    </div>

                    @if($domains->isNotEmpty())
                        <div class="mt-6 mx-4 border border-gray-100 border-b-4"></div>
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
