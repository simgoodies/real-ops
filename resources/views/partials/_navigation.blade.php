<nav x-data="{menuOpen: false, profileOpen: false}" class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">

                <button @click="menuOpen = !menuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out" aria-label="Main menu" aria-expanded="false">


                    <svg :class="{'block': !menuOpen, 'hidden': menuOpen}" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>


                    <svg :class="{'block': menuOpen, 'hidden': !menuOpen}" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex-shrink-0">
                    <a href="{{ route('landing-pages.index') }}">
                        <img class="block h-8 w-auto" src="{{ asset('images/favicon/android-chrome-512x512.png') }}" alt="Simgoodes Logo">
                    </a>
                </div>
                <div class="hidden sm:block sm:ml-6">
                    <div class="flex">
                        <a href="{{ route('office.index') }}" class="px-3 py-2 rounded-md text-sm font-medium leading-5 text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Office</a>
                    </div>
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">

                <div class="ml-3 relative">
                    <div>
                        <button @click="profileOpen = !profileOpen" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-white transition duration-150 ease-in-out" id="user-menu" aria-label="User menu" aria-haspopup="true">
                            <img class="h-8 w-8 rounded-full" src="{{ Gravatar::src(auth()->user()->email, 200) }}" alt="">
                        </button>
                    </div>

                    <div x-show="profileOpen" class="transition transform origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg">
                        <div class="py-1 rounded-md bg-white shadow-xs" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                            <div class="w-full">
                                <form action="{{ route('tenant-logout') }}" method="post">
                                    @csrf
                                    <input class="w-full text-left bg-transparent block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" type="submit" value="Logout">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div :class="{'block': menuOpen, 'hidden': !menuOpen}" class="sm:hidden">
        <div class="px-2 pt-2 pb-3">
            <a href="{{ route('office.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out">Office</a>
        </div>
    </div>
</nav>
