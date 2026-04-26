<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="group flex items-center">
                        <span class="text-2xl font-black tracking-tighter transition-all duration-300 transform group-hover:scale-105">
                            <span class="text-emerald-600 dark:text-emerald-500">Uni</span><span class="text-gray-800 dark:text-white">Event</span><span class="text-emerald-600">.</span>
                        </span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-width="2"/>
                        </svg>
                        Inicio
                    </x-nav-link>

                    <x-nav-link href="/events/create" :active="request()->is('events/create')" class="inline-flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4v16m8-8H4" stroke-width="2"/>
                        </svg>
                        Crear evento
                    </x-nav-link>

                    <x-nav-link href="/mis-eventos" :active="request()->is('mis-eventos')" class="inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-width="2"/>
                        </svg>
                        Mis eventos
                    </x-nav-link>

                    
                    <x-nav-link href="/mis-inscripciones" :active="request()->is('mis-inscripciones')" class="inline-flex items-center gap-2">
                        Mis inscripciones
                    </x-nav-link>

                    @if(auth()->user()->role === 'admin')
                        <x-nav-link href="/events/pending" :active="request()->is('events/pending')" class="inline-flex items-center gap-2 text-amber-500 font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/>
                            </svg>
                            Pendientes
                        </x-nav-link>
                    @endif

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300">
                            <div class="flex items-center gap-2 font-bold">
                                <div class="w-7 h-7 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-emerald-700 dark:text-emerald-300 text-xs">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                {{ Auth::user()->name }}
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Perfil</x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar Sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 text-gray-400 hover:text-gray-500 rounded-lg">
                    ☰
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile Menu -->
<div x-show="open" class="sm:hidden px-4 pt-4 pb-2 space-y-2 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">

    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-200">
        Inicio
    </a>

    <a href="/events/create" class="block px-3 py-2 rounded-md text-base font-medium text-emerald-600">
        Crear evento
    </a>

    <a href="/mis-eventos" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-200">
        Mis eventos
    </a>

    <a href="/mis-inscripciones" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-200">
        Mis inscripciones
    </a>

    @if(auth()->user()->role === 'admin')
        <a href="/events/pending" class="block px-3 py-2 rounded-md text-base font-medium text-amber-500">
            Pendientes
        </a>
    @endif

</div>

</nav>