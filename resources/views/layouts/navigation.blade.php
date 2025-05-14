<nav x-data="{ open: false }" class="w-full bg-blue-700 text-white border-b border-gray-200">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
                <!-- Logo (optional, can be added if needed) -->
                <!-- <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    </a>
                </div> -->

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ml-6 sm:flex">
                    @auth
                        @if (auth()->user()->user_type === 'candidate')
                            <x-nav-link :href="route('candidate.jobs.index')" :active="request()->routeIs('candidate.jobs.*')" class="text-white hover:text-gray-300">
                                Jobs
                            </x-nav-link>
                            <x-nav-link :href="route('candidate.applications')" :active="request()->routeIs('candidate.applications')" class="text-white hover:text-gray-300">
                                My Applications
                            </x-nav-link>
                            <x-nav-link :href="route('candidate.settings')" :active="request()->routeIs('candidate.settings')" class="text-white hover:text-gray-300">
                                Settings
                            </x-nav-link>
                  
                        @endif
                    @endauth
                </div>
            </div>

            <!-- User Dropdown (on the right) -->
            <div class="hidden sm:flex sm:items-center sm:mr-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-transparent hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Profile
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-300 hover:bg-blue-600 focus:outline-none focus:bg-blue-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if (auth()->user()->user_type === 'candidate')
                    <x-responsive-nav-link :href="route('candidate.jobs.index')" :active="request()->routeIs('candidate.jobs.*')">
                        Jobs
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('candidate.applications')" :active="request()->routeIs('candidate.applications')">
                        My Applications
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('candidate.settings')" :active="request()->routeIs('candidate.settings')">
                        Settings
                    </x-responsive-nav-link>
            
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        Profile
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            Log Out
                        </x-dropdown-link>
                    </form>
                </div>
            @else
                <x-responsive-nav-link :href="route('login')">
                    Log in
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    Register
                </x-responsive-nav-link>
            @endauth
        </div>
    </div>
</nav>