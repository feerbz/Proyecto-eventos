<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            {{-- LADO IZQUIERDO: LOGO Y ENLACES --}}
            <div class="flex">
                
                {{-- Logo --}}
                <div class="shrink-0 flex items-center mr-8">
                    <a href="{{ route('dashboard') }}" class="group flex items-center">
                        <span class="text-2xl font-black tracking-tighter transition-all duration-300 transform group-hover:scale-105">
                            <span class="text-emerald-600 dark:text-emerald-500">Uni</span><span class="text-gray-800 dark:text-white">Event</span><span class="text-emerald-600">.</span>
                        </span>
                    </a>
                </div>

                {{-- Enlaces de Navegación Desktop --}}
                <div class="hidden sm:flex sm:space-x-1">
                    
                    {{-- Inicio --}}
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="inline-flex items-center gap-2 px-3 pt-1 border-b-2 transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 font-medium' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Inicio
                    </x-nav-link>

                    {{-- Calendario --}}
                    <x-nav-link href="/calendario" :active="request()->is('calendario')"
                        class="inline-flex items-center gap-2 px-3 pt-1 border-b-2 transition-colors duration-200 {{ request()->is('calendario') ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 font-medium' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Calendario
                    </x-nav-link>

                    {{-- Separador Visual --}}
                    <div class="hidden lg:flex items-center mx-2">
                        <div class="h-6 w-px bg-gray-200 dark:bg-gray-700"></div>
                    </div>

                    {{-- Favoritos --}}
                    <x-nav-link href="/favoritos" :active="request()->is('favoritos')"
                        class="inline-flex items-center gap-2 px-3 pt-1 border-b-2 transition-colors duration-200 {{ request()->is('favoritos') ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 font-medium' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        Favoritos
                    </x-nav-link>

                    {{-- Mis Inscripciones --}}
                    <x-nav-link href="/mis-inscripciones" :active="request()->is('mis-inscripciones')"
                        class="inline-flex items-center gap-2 px-3 pt-1 border-b-2 transition-colors duration-200 {{ request()->is('mis-inscripciones') ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 font-medium' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Inscripciones
                    </x-nav-link>

                    {{-- Historial --}}
                    <x-nav-link href="/historial" :active="request()->is('historial')"
                        class="inline-flex items-center gap-2 px-3 pt-1 border-b-2 transition-colors duration-200 {{ request()->is('historial') ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 font-medium' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Historial
                    </x-nav-link>

                    {{-- Mis Eventos (Los que yo creé) --}}
                    <x-nav-link href="/mis-eventos" :active="request()->is('mis-eventos')"
                        class="inline-flex items-center gap-2 px-3 pt-1 border-b-2 transition-colors duration-200 {{ request()->is('mis-eventos') ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 font-medium' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        Mis Eventos
                    </x-nav-link>

                </div>
            </div>

            {{-- LADO DERECHO: BOTÓN CREAR Y PERFIL --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-6">
                
                {{-- Botón Crear Evento (Resaltado) --}}
                <a href="/events/create" class="inline-flex items-center gap-2 px-4 py-2 border border-emerald-500 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 rounded-lg text-sm font-bold transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Crear evento
                </a>

                {{-- Menú de Usuario (Dropdown) --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm rounded-lg text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors focus:outline-none">
                            <div class="flex items-center gap-2 font-bold">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 flex items-center justify-center text-white text-xs font-black shadow-inner">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="/profile" class="font-medium">
                            👤 Mi Perfil
                        </x-dropdown-link>

                        {{-- Opciones de Administrador --}}
                        @if(auth()->user()->role === 'admin')
                            <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
                            <div class="block px-4 py-2 text-xs text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-wider">
                                Administración
                            </div>
                            
                            <x-dropdown-link href="/events/pending">Pendientes</x-dropdown-link>
                            <x-dropdown-link href="/spaces">Administrar espacios</x-dropdown-link>
                            <x-dropdown-link href="/spaces/create">Crear espacio</x-dropdown-link>
                            <x-dropdown-link href="/categories">Categorías</x-dropdown-link>
                            <x-dropdown-link href="/metricas">Métricas</x-dropdown-link>
                            <x-dropdown-link href="/attendance">Control asistencia</x-dropdown-link>
                        @endif

                        <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>

                        {{-- Cerrar Sesión --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 dark:text-red-400 font-bold hover:bg-red-50 dark:hover:bg-red-900/20">
                                🚪 Cerrar Sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- BOTÓN HAMBURGUESA (Móvil) --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENÚ MÓVIL (Se despliega al hacer clic en hamburguesa) --}}
    <div x-show="open" class="sm:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-lg">
        <div class="pt-2 pb-3 space-y-1 px-4">
            
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">Inicio</a>
            
            <a href="/calendario" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->is('calendario') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">Calendario</a>
            
            <a href="/favoritos" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->is('favoritos') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">Favoritos</a>
            
            <a href="/mis-inscripciones" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->is('mis-inscripciones') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">Inscripciones</a>
            
            <a href="/historial" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->is('historial') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">Historial</a>
            
            <a href="/mis-eventos" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->is('mis-eventos') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">Mis eventos</a>

            <a href="/events/create" class="block px-3 py-2 rounded-lg text-base font-bold bg-emerald-600 text-white hover:bg-emerald-700 text-center mt-4">
                + Crear evento
            </a>

            {{-- Opciones Móvil Admin --}}
            @if(auth()->user()->role === 'admin')
                <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                    <p class="px-3 text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Administración</p>
                    <a href="/events/pending" class="block px-3 py-2 rounded-lg text-base font-medium text-amber-600 hover:bg-amber-50">Pendientes</a>
                    <a href="/spaces/create" class="block px-3 py-2 rounded-lg text-base font-medium text-indigo-600 hover:bg-indigo-50">Crear espacio</a>
                </div>
            @endif

        </div>
    </div>
</nav>