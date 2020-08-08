@extends('main')

@section('title', 'Create an account!')

@section('main-content')
    <div class="mt-12 sm:mt-16 lg:mt-0 lg:col-span-6">
        <div class="sm:max-w-md sm:w-full sm:mx-auto sm:rounded-lg sm:overflow-hidden">
            <div class="px-4 py-8 sm:px-10">
                <div class="mt-6">
                    <div>
                        <img class="mx-auto h-12 w-auto" src="images/favicon/android-chrome-512x512.png" alt="Simgoodies Logo">
                        <h2 class="mt-6 text-center text-2xl leading-9 font-extrabold text-gray-900">
                            Create your acccount!
                        </h2>
                    </div>
                    <form method="post" class="mt-8 space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="sr-only">
                                Full name
                            </label>
                            <div class="rounded-md shadow-sm">
                                <input id="name" name="name" type="text" placeholder="Full name" required class="input w-full">
                            </div>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

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

                        <div>
                            <label for="password-confirmation" class="sr-only">
                                Password
                            </label>
                            <div class="rounded-md shadow-sm">
                                <input id="password-confirmation" name="password_confirmation" type="password" placeholder="Password confirmation" required class="input w-full">
                            </div>
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div>
                          <span class="block w-full rounded-md shadow-sm">
                            <button type="submit" class="btn btn-blue w-full">
                              Create your account
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
                                  Have one already?
                                </span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('login') }}">
                            <button class="w-full btn btn-blue-secondary">
                                Login
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
