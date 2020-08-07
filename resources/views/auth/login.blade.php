@extends('main')

@section('title', 'Login')

@section('main-content')
    <div class="mt-12 sm:mt-16 lg:mt-0 lg:col-span-6">
        <div class="sm:max-w-md sm:w-full sm:mx-auto sm:rounded-lg sm:overflow-hidden">
            <div class="px-4 py-8 sm:px-10">
                <div class="mt-6">
                    <div>
                        <img class="mx-auto h-12 w-auto" src="images/favicon/android-chrome-512x512.png" alt="Simgoodies Logo">
                        <h2 class="mt-6 text-center text-2xl leading-9 font-extrabold text-gray-900">
                            Login to realops!
                        </h2>
                    </div>
                    <form action="#" method="post" class="mt-8 space-y-6">
                        @csrf
                        <div>
                            <label for="email" class="sr-only">
                                Email
                            </label>
                            <div class="rounded-md shadow-sm">
                                <input id="email" name="email" type="email" placeholder="Email" required class="input w-full">
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
                                <input id="password" name="password" type="password" placeholder="Password" required class="input w-full">
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="flex -mx-2">
                          <a href="{{ route('password.request') }}" class="p-2 block w-2/3 rounded-md shadow-sm">
                            <div class="w-full btn btn-blue-tertiary">
                              Forgot password?
                            </div>
                          </a>
                          <span class="p-2 block w-1/3 rounded-md shadow-sm">
                            <button type="submit" class="w-full btn btn-blue">
                              Login
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
