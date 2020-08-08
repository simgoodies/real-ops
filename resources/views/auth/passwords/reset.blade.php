@extends('main')

@section('title', 'Reset password')

@section('main-content')
    <div class="mt-12 sm:mt-16 lg:mt-0 lg:col-span-6">
        <div class="sm:max-w-md sm:w-full sm:mx-auto sm:rounded-lg sm:overflow-hidden">
            <div class="px-4 py-8 sm:px-10">
                <div class="mt-6">
                    <div>
                        <img class="mx-auto h-12 w-auto" src="{{ asset('images/favicon/android-chrome-512x512.png') }}" alt="Simgoodies Logo">
                        <h2 class="mt-6 text-center text-2xl leading-9 font-extrabold text-gray-900">
                            Reset your password!
                        </h2>
                    </div>
                    <form action="{{ route('password.update') }}" method="post" class="mt-8 space-y-6">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
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
                              Reset Password
                            </button>
                          </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
