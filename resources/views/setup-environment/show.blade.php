@extends('main')

@section('title', 'Register')

@section('main-content')
    <div class="mt-12 sm:mt-16 lg:mt-0 lg:col-span-6">
        <div class="sm:max-w-md sm:w-full sm:mx-auto sm:rounded-lg sm:overflow-hidden">
            <div class="px-4 py-8 sm:px-10">
                <div class="mt-6">
                    <div>
                        <img class="mx-auto h-12 w-auto" src="images/favicon/android-chrome-512x512.png" alt="Simgoodies Logo">
                        <h2 class="mt-6 text-center text-2xl leading-9 font-extrabold text-gray-900">
                            Setup an environment!
                        </h2>
                    </div>
                    <form action="#" method="post" class="mt-8 space-y-6">
                        @csrf
                        <div>
                            <div class="px-6 py-4 my-4 font-light rounded bg-white border-2 border-blue-200">
                                The environment name is a name you and others want to identify this environment as. (e.g. London, VATUSA, Ryanair)
                                <br><br>
                                The subdomain is the url that you want to use to go to the environment.
                            </div>

                            <label for="name" class="sr-only">
                                Name
                            </label>
                            <div class="rounded-md shadow-sm">
                                <input id="name" name="name" type="name" placeholder="Name for Environment" required class="input w-full">
                            </div>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div>
                            <label for="subdomain" class="sr-only">
                                Subdomain
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <input id="subdomain" name="subdomain" type="text" placeholder="Subdomain" required class="pr-8 input w-full" style="padding-right: 12.5rem">
                                <div class="ml-auto mr-4 mt-1 absolute top-0 right-0">.{{ config('app.url_base') }}</div>
                            </div>
                            @error('subdomain')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div>
                          <span class="block w-full rounded-md shadow-sm">
                            <button type="submit" class="w-full btn btn-blue">
                              Setup environment
                            </button>
                          </span>
                        </div>
                    </form>

                    <div class="mt-6 relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm leading-5">
                                <span class="px-2 bg-gray-50 text-gray-500">
                                  Login to existing one?
                                </span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('login-to-environment.index') }}">
                            <button class="w-full btn btn-blue-secondary">
                                Select environment for login
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
