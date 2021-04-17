@extends('main')

@section('title', 'Login')

@section('main-content')
    <div class="mt-12 sm:mt-16 lg:mt-0 lg:col-span-6">
        <div class="sm:max-w-md sm:w-full sm:mx-auto sm:rounded-lg sm:overflow-hidden">
            <div class="px-4 py-8 sm:px-10">
                <div class="mt-6">
                    <div>
                        <img class="w-auto h-12 mx-auto" src="images/favicon/android-chrome-512x512.png" alt="Simgoodies Logo">
                        <h2 class="mt-6 text-2xl font-extrabold leading-9 text-center text-gray-900">
                            Login to realops!
                        </h2>
                    </div>
                    @include('partials._messages')
                    
                    <form action="#" method="post" class="mt-8 space-y-6">
                        @csrf
                        <div>
                            <label for="email" class="sr-only">
                                Email
                            </label>
                            <div class="rounded-md shadow-sm">
                                <input id="email" name="email" type="email" placeholder="Email" required class="w-full input">
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="sr-only">
                                Password
                            </label>
                            <div class="rounded-md shadow-sm">
                                <input id="password" name="password" type="password" placeholder="Password" required class="w-full input">
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="flex -mx-2">
                          <a href="{{ route('password.request') }}" class="block w-2/3 p-2 rounded-md shadow-sm">
                            <div class="w-full btn btn-blue-tertiary">
                              Forgot password?
                            </div>
                          </a>
                          <span class="block w-1/3 p-2 rounded-md shadow-sm">
                            <button type="submit" class="w-full btn btn-blue">
                              Login
                            </button>
                          </span>
                        </div>
                    </form>

                    <div class="relative mt-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm leading-5">
                                <span class="px-2 text-gray-500 bg-gray-50">
                                  Don't have one yet?
                                </span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('register') }}">
                            <button class="w-full btn btn-blue-secondary">
                                Create account
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
