<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark scroll-smooth md:scroll-auto" >
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
    {{-- Desktop Bottom Nav --}}
<nav x-data="{ open: false }" class="bg-white/95 dark:bg-zinc-900/95 border-b border-gray-200 dark:border-gray-600 sticky top-0 w-auto mx-auto z-50 py-2">
    <div class="container mx-auto flex flex-wrap items-center justify-between p-4">

        <div class="flex items-center">
            <a href="{{route('home')}}" class="flex items-center"> 
                <img src="https://ayo.co.id/assets/logo/new-logo.svg" class="h-8 w-auto" alt="AYO Logo" />
            </a>

            <div class="hidden md:flex items-center ml-10 space-x-8">
                <a href="{{route('lapangan')}}" class="text-sm font-medium text-gray-700 hover:text-red-700 dark:text-gray-300 dark:hover:text-red-500">Sewa Lapangan</a>
                <a href="#competitions" class="text-sm font-medium text-gray-700 hover:text-red-700 dark:text-gray-300 dark:hover:text-red-500">Cari Kompetisi</a>
                <a href="#" class="text-sm font-medium text-gray-700 hover:text-red-700 dark:text-gray-300 dark:hover:text-red-500">Sparring</a>
                <a href="#" class="text-sm font-medium text-gray-700 hover:text-red-700 dark:text-gray-300 dark:hover:text-red-500">Partner With Us</a>
                <a href="#" class="text-sm font-medium text-gray-700 hover:text-red-700 dark:text-gray-300 dark:hover:text-red-500">Liga AYO</a>
                <a href="#" class="text-sm font-medium text-gray-700 hover:text-red-700 dark:text-gray-300 dark:hover:text-red-500">Blog</a>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle" aria-label="Toggle dark mode" />
            <div class="h-6 w-px bg-zinc-300 dark:bg-zinc-600"></div>
                @guest
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-red-700 dark:text-gray-300 dark:hover:text-red-500">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-red-700 hover:bg-red-800 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">Daftar</a>
                    </div>
                @endguest

                @auth
                    <div x-data="{ dropdownOpen: false }" class="relative" @click.away="dropdownOpen = false">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-2">
                            <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="{{ Auth::user()->name }}">
                            {{-- <span class="font-semibold text-sm text-gray-700 dark:text-gray-200">{{ Auth::user()->name }}</span> --}}
                            <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{'rotate-180': dropdownOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="dropdownOpen" x-transition class="absolute right-0 mt-2 w-48 bg-white dark:bg-zinc-800 rounded-md shadow-lg border dark:border-zinc-700 py-1" style="display: none;">
                            <a href="{{route('settings.profile')}}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-zinc-700">Profile</a>
                            <a href="{{route('profile.showlist')}}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-zinc-700">Histori Pemesanan</a>
                            <div class="border-t border-gray-100 dark:border-zinc-700 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); this.closest('form').submit();"
                                   class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-zinc-700">
                                    Logout
                                </a>
                            </form>
                        </div>
                    </div>
                @endauth

            <button @click="open = !open" type="button" class="inline-flex md:hidden items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 focus:outline-none">
                <span class="sr-only">Buka menu</span>
                <svg x-show="!open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                <svg x-show="open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    </div>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="md:hidden absolute w-full bg-white dark:bg-zinc-900 border-b border-gray-200 dark:border-gray-600"
         style="display: none;">
        <div class="px-4 pt-2 pb-4 space-y-2">
            <a href="{{route('lapangan')}}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-zinc-800">Sewa Lapangan</a>
            <a href="#competitions" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-zinc-800">Cari Kompetisi</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-zinc-800">Sparring</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-zinc-800">Partner With Us</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-zinc-800">Liga AYO</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-zinc-800">Blog</a>
            
            <div class="border-t border-gray-200 dark:border-gray-600 pt-4 mt-4 flex items-center space-x-4">
                @guest
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="flex-1 text-center bg-gray-100 dark:bg-zinc-800 text-gray-800 dark:text-gray-200 font-semibold py-2 px-4 rounded-lg">Masuk</a>
                        <a href="{{ route('register') }}" class="flex-1 text-center bg-red-700 text-white font-semibold py-2 px-4 rounded-lg">Daftar</a>
                    </div>
                @endguest
                @auth
                    <div class="space-y-2">
                        <div class="flex items-center gap-3 px-3">
                            <img class="h-10 w-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="{{ Auth::user()->name }}">
                            <div>
                                <div class="font-bold text-base text-gray-800 dark:text-white">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <a href="{{route('settings.profile')}}" class="block px-3 py-2 rounded-md text-base font-medium">Profile</a>
                        <a href="{{route('profile.showlist')}}" class="block px-3 py-2 rounded-md text-base font-medium">Histori Pemesanan</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium ...">
                                Logout
                            </a>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

    {{-- Slot --}}
      <main>
            {{ $slot }}
      </main>


    <x-layouts.app.footer/>

@include('partials.script')
</body>
</html>