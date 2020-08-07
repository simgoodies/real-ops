@extends('main')

@section('title', 'Verify Email')

@section('main-content')
    <div class="mt-12 sm:mt-16 lg:mt-0 lg:col-span-6">
        <div class="sm:max-w-md sm:w-full sm:mx-auto sm:rounded-lg sm:overflow-hidden">
            <div class="px-4 py-8 sm:px-10">
                <div class="mt-6">
                    <div>
                        <img class="mx-auto h-12 w-auto" src="{{ asset('images/favicon/android-chrome-512x512.png') }}" alt="Simgoodies Logo">
                        <h2 class="mt-6 text-center text-2xl leading-9 font-extrabold text-gray-900">
                            Verify your email!
                        </h2>
                    </div>
                    <div class="mt-6">
                        @if (session('resent'))
                            <div class="p-2 bg-green-200 text-green-800 border-2 border-green-700">
                                A fresh verification link has been sent to your email address.
                            </div>
                        @endif
                    </div>
                    <div class="mt-6">
                        <p>
                            Before proceeding, please check your email for a verification link.
                        </p>
                        <p>
                            If you did not receive the email.
                        </p>
                    </div>

                    <form action="{{ route('verification.resend') }}" method="post" class="mt-8 space-y-6">
                        @csrf
                        <div>
                            <span class="rounded-md shadow-sm">
                                <button type="submit" class="w-full btn btn-blue">
                                  Click here to request another
                                </button>
                          </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
