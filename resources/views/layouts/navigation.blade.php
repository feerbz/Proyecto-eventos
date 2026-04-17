<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

    <!-- CONTENEDOR PRINCIPAL -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- BARRA -->
        <div class="flex justify-between h-16">

            <!-- IZQUIERDA (logo + links) -->
            <div class="flex">

                <!-- LOGO -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- LINKS -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    <!-- Inicio -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Inicio
                    </x-nav-link>

                    <!-- Crear evento -->
                    <x-nav-link href="/events/create">
                        Crear evento
                    </x-nav-link>

                    <!-- Mis eventos -->
                    <x-nav-link href="/mis-eventos">
                        Mis eventos
                    </x-nav-link>

                    <!-- SOLO ADMIN -->
                    @if(auth()->user()->role === 'admin')
                        <x-nav-link href="/events/pending">
                            Pendientes
                        </x-nav-link>
                    @endif

                </div>

            </div>

            <!-- DERECHA (usuario dropdown) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <x-dropdown align="right" width="48">

                    <!-- BOTÓN -->
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300">
                            <div>{{ Auth::user()->name }}</div>
                        </button>
                    </x-slot>

                    <!-- MENÚ -->
                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>

                    </x-slot>

                </x-dropdown>

            </div>

            <!-- HAMBURGER (móvil) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 text-gray-400 hover:text-gray-500">
                    ☰
                </button>
            </div>

        </div>
    </div>

    <!-- MENÚ RESPONSIVE -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link :href="route('dashboard')">
                Inicio
            </x-responsive-nav-link>

            <x-responsive-nav-link href="/events/create">
                Crear evento
            </x-responsive-nav-link>

            <x-responsive-nav-link href="/mis-eventos">
                Mis eventos
            </x-responsive-nav-link>

            @if(auth()->user()->role === 'admin')
                <x-responsive-nav-link href="/events/pending">
                    Pendientes
                </x-responsive-nav-link>
            @endif

        </div>

    </div>

</nav>
