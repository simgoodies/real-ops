@extends('main')

@section('main-content')
    <div class="relative bg-blue-50 overflow-hidden">
        <div class="max-w-screen-xl mx-auto">
            <div x-data="{open: false}" class="relative z-10 pb-8 bg-blue-50 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-blue-50 transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>

                <div class="relative pt-6 px-4 sm:px-6 lg:px-8">
                    <nav class="relative flex items-center justify-between sm:h-10 lg:justify-start">
                        <div class="flex items-center flex-grow flex-shrink-0 lg:flex-grow-0">
                            <div class="flex items-center justify-between w-full md:w-auto">
                                <a href="#" aria-label="Home">
                                    <img class="h-8 w-auto sm:h-10" src="images/favicon/android-chrome-512x512.png" alt="Logo">
                                </a>
                                <div class="-mr-2 flex items-center md:hidden">
                                    <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" id="main-menu" aria-label="Main menu" aria-haspopup="true">
                                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="hidden md:block md:ml-10 md:pr-4">
                            <a href="#features" class="ml-8 font-medium text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out">Features</a>
                            <a target="_blank" href="https://simgoodies.app/discord" class="ml-8 font-medium text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out">Discord</a>
                            <a href="{{ route('login') }}" class="ml-8 font-medium text-gray-500 hover:text-blue-900 transition duration-150 ease-in-out">Log in</a>
                            <span class="mx-8">or</span>
                            <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-900 transition duration-150 ease-in-out">Create account</a>
                        </div>
                    </nav>
                </div>

                <div x-show="open" class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
                    <div class="rounded-lg shadow-md">
                        <div class="rounded-lg bg-white shadow-xs overflow-hidden" role="menu" aria-orientation="vertical" aria-labelledby="main-menu">
                            <div class="px-5 pt-4 flex items-center justify-between">
                                <div>
                                    <img class="h-8 w-auto" src="images/favicon/android-chrome-512x512.png" alt="Simgoodes Logo">
                                </div>
                                <div class="-mr-2">
                                    <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" aria-label="Close menu">
                                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="px-2 pt-2 pb-3">
                                <a href="#features" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out" role="menuitem">Features</a>
                                <a target="_blank" href="https://simgoodies.app/discord" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out" role="menuitem">Discord</a>
                                <a href="{{ route('login') }}" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out" role="menuitem">Login</a>
                            </div>
                            <div>
                                <a href="{{ route('register') }}" class="block w-full px-5 py-3 text-center font-medium text-blue-600 bg-gray-50 hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:bg-gray-100 focus:text-blue-700 transition duration-150 ease-in-out" role="menuitem">
                                    Create account
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <main class="mt-10 mx-auto max-w-screen-xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h2 class="text-3xl tracking-tight leading-10 font-extrabold text-gray-900 sm:text-5xl sm:leading-none md:text-6xl">
                            Real Ops
                            <br />
                            <span class="text-blue-600">a simgoodies.app</span>
                        </h2>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Look no further, you've found the flight sim booking platform you've been looking for!
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10">
                                    Create account
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="images/realops-landing.jpeg" alt="">
        </div>
    </div>

    {{-- features   --}}
    <div class="py-12 bg-blue-50">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h3 class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
                    Does this sound familiar to you?
                </h3>
{{--                    <div class="max-w-3xl mx-auto text-center text-2xl leading-9 font-medium text-gray-900">--}}
{{--                        <p>does this sound familiar?</p>--}}
{{--                    </div>--}}
                <div class="md:-mx-2 md:flex">
                    <div class="mt-10 max-w-3xl mx-auto text-center text-xl leading-9 font-medium text-gray-900 md:mt-4 md:px-2">
                        <p>
                            &ldquo;I have an idea for this event, if only I had a booking system that people could use to join the event!&rdquo;
                        </p>
                    </div>
                    <div class="mt-4 max-w-3xl mx-auto text-center text-xl leading-9 font-medium text-gray-900 md:px-2">
                        <p>
                            &ldquo;Everybody is showing up at the same time, isn't there a booking system out there that can help me space out things?&rdquo;
                        </p>
                    </div>
                    <div class="mt-4 max-w-3xl mx-auto text-center text-xl leading-9 font-medium text-gray-900 md:px-2">
                        <p>
                            &ldquo;Honestly I have no time to spend attempting to make my own booking system. I have an event to coordinate!&rdquo;
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- i'm sold cta   --}}
    <div class="bg-gray-800">
        <div class="max-w-screen-xl mx-auto pt-4 pb-8 px-4 sm:px-6 lg:py-12 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl leading-9 font-extrabold tracking-tight text-white sm:text-4xl sm:leading-10">
                I'm sold already, <span class="ml-1 text-blue-200"> I want to create my account!</span>
            </h2>
            <div class="mt-8 flex lg:flex-shrink-0 lg:mt-0">
                <div class="inline-flex rounded-md shadow ">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-gray-900 bg-white hover:text-gray-600 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        Create account!
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8 bg-blue-50">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="features"></div>
            <div class="mt-10 lg:text-center">
                <h3 class="text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
                    Event organizers who need a (better) platform!
                </h3>
                <p class="mt-4 max-w-2xl text-xl leading-7 text-gray-500 lg:mx-auto">
                    Say hi to <span class="font-semibold">Real Ops</span>, a flexible flight sim event booking platform! Find out below some of the things you'll be able to do.
                </p>
            </div>

            <div class="mt-10">
                <ul class="md:grid md:grid-cols-2 md:col-gap-8 md:row-gap-10">
                    <li>
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg leading-6 font-medium text-gray-900">Event Administration</h4>
                                <p class="mt-2 text-base leading-6 text-gray-500">
                                    All the required things you need to create and administrate your event. Create your event, name it, set the time and date, put up a banner and add your flights!
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="mt-10 md:mt-0">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg leading-6 font-medium text-gray-900">Mailed Booking Confirmations</h4>
                                <p class="mt-2 text-base leading-6 text-gray-500">
                                    Booking confirmation with just e-mail! Real Ops will take care of sending out booking request and confirmation e-mails.
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="mt-10 md:mt-0">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg leading-6 font-medium text-gray-900">Multiple Booking Types</h4>
                                <p class="mt-2 text-base leading-6 text-gray-500">
                                    Not quite organizing a real ops? No problem. Real Ops supports multiple types of "bookables". This means that you can run more than just an real ops event!
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="mt-10 md:mt-0">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg leading-6 font-medium text-gray-900">Invite your staff</h4>
                                <p class="mt-2 text-base leading-6 text-gray-500">
                                    We're sure that you'd want some help while organizing things! Invite your staff members so they can help along!
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <p class="mt-4 max-w-2xl text-sm leading-7 text-gray-500 font-light lg:mx-auto">
                Note: Real Ops by simgoodies.app is continuously developed, this means that some features may not be fully available yet. Please join the
                <a target="_blank" class="underline" href="https://simgoodies.app/discord">discord</a> and let us know what features you're looking forward to.
            </p>
        </div>
    </div>

    {{--  cta discord  --}}
    <div class="relative bg-gray-800">
        <div class="h-56 bg-blue-600 sm:h-72 md:absolute md:left-0 md:h-full md:w-1/2">
            <img class="w-full h-full object-cover" src="images/binos.jpeg" alt="Support team">
        </div>
        <div class="relative max-w-screen-xl mx-auto px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
            <div class="md:ml-auto md:w-1/2 md:pl-10">
                <h2 class="mt-2 text-white text-3xl leading-9 font-extrabold tracking-tight sm:text-4xl sm:leading-10">
                    Join the Simgoodies community
                </h2>
                <p class="mt-3 text-lg leading-7 text-gray-300">
                    Want to introduce yourself? Have any question that you want to ask? Or just want to share some suggestions / ideas? Feel free to join our discord community and chat with us.
                </p>
                <div class="mt-8">
                    <div class="inline-flex rounded-md shadow">
                        <a href="https://simgoodies.app/discord" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-gray-900 bg-white hover:text-gray-600 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                            Join Discord
                            <svg class="-mr-1 ml-3 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                                <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                            </svg>
                        </a>
                        <a href="{{ route('register') }}" class="ml-4 inline-flex items-center justify-center px-5 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-gray-900 bg-white hover:text-gray-600 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                            Create an account!
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- who am i  --}}
    <section class="py-12 bg-blue-50 overflow-hidden md:py-20 lg:py-24">
        <div class="relative max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative">
                <a target="_blank" href="https://simgoodies.app">
                    <img class="mx-auto h-20" src="images/simgoodies-logo.png" alt="Simgoodies Logo">
                </a>
                <blockquote class="mt-8">
                    <div class="max-w-3xl mx-auto text-center text-xl leading-9 font-medium text-gray-900 md:text-2xl lg:max-w-4xl">
                        <p>
                            &ldquo;My wish is that you enjoy using the real ops goodie. A goodie provided to you by
                            <a href="https://simgoodies.app" class="underline">simgoodies.app</a>. You can expect more coming from the side of Simgoodies!
                            <br class="hidden lg:block"> Thanks for trusting us with your events!&rdquo;
                        </p>
                    </div>
                    <footer class="mt-8">
                        <div class="md:flex md:items-center md:justify-center">
                            <div class="mt-3 text-center md:mt-0 md:ml-4 md:flex md:items-center">
                                <div class="text-base leading-6 font-medium text-gray-900">Roël Gonzalez</div>

                                <svg class="hidden md:block mx-1 h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M11 0h3L9 20H6l5-20z" />
                                </svg>

                                <div class="text-base leading-6 font-medium text-gray-500">Simgoodies Creator</div>
                            </div>
                        </div>
                    </footer>
                </blockquote>
            </div>
        </div>
    </section>


    {{-- footer  --}}
    <div class="bg-blue-50">
        <div class="max-w-screen-xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
            <nav class="-mx-5 -my-2 flex flex-wrap justify-center">
                <div class="px-5 py-2">
                    <a target="_blank" href="https://simgoodies.app/discord" class="text-base leading-6 text-gray-500 hover:text-gray-900">
                        Discord
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a class="typeform-share button text-base leading-6 text-gray-500 hover:text-gray-900" href="https://form.typeform.com/to/CjREly" data-mode="popup" data-submit-close-delay="2" target="_blank">Contact</a> <script> (function() { var qs,js,q,s,d=document, gi=d.getElementById, ce=d.createElement, gt=d.getElementsByTagName, id="typef_orm_share", b="https://embed.typeform.com/"; if(!gi.call(d,id)){ js=ce.call(d,"script"); js.id=id; js.src=b+"embed.js"; q=gt.call(d,"script")[0]; q.parentNode.insertBefore(js,q) } })() </script>
                </div>
                <div class="px-5 py-2">
                    <a href="{{ route('login') }}" class="text-base leading-6 text-gray-500 hover:text-gray-900">
                        Login
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="{{ route('register') }}" class="text-base leading-6 text-gray-500 hover:text-gray-900">
                        Create an account!
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a target="_blank" href="https://simgoodies.app" class="text-base leading-6 text-gray-500 hover:text-gray-900">
                        Simgoodies.app
                    </a>
                </div>
            </nav>
            <div class="mt-8">
                <p class="text-center text-base leading-6 text-gray-400">
                    Real Ops a <a target="_blank" class="underline" href="https://simgoodies.app">simgoodies.app</a> ~ 2018 - {{ now()->year }}
                </p>
            </div>
        </div>
    </div>
@endsection
