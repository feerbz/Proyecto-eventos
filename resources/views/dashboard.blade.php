<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tighter">
                    Cartelera <span class="text-emerald-600">Universitaria</span>
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                    Descubre los próximos eventos en tu comunidad.
                </p>
            </div>

            <a href="/events/create"
                class="inline-flex items-center justify-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-emerald-500/20 active:scale-95">
                + Proponer Evento
            </a>
        </div>
    </x-slot>

    {{-- MENSAJES --}}
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-6">
            <div class="bg-emerald-50 dark:bg-emerald-900/30 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm">
                <p class="text-emerald-800 dark:text-emerald-300 font-bold text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-6">
            <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
                <p class="text-red-800 dark:text-red-300 font-bold text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- FILTRO --}}
            <form method="GET" action="{{ route('dashboard') }}" class="mb-8 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center gap-4">
                <label class="text-sm font-bold text-gray-700 dark:text-gray-300 whitespace-nowrap">
                    Filtro rápido:
                </label>
                <select name="category" onchange="this.form.submit()"
                    class="w-full sm:w-64 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 text-sm font-medium transition-colors">
                    <option value="">Todas las categorías</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </form>

            {{-- GRID DE EVENTOS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse ($events as $event)
                    @php
                        $favorito = \App\Models\Favorite::where('user_id', auth()->id())->where('event_id', $event->id)->exists();
                        $inscrito = \App\Models\Registration::where('user_id', auth()->id())->where('event_id', $event->id)->exists();
                        $enEspera = \App\Models\Waitlist::where('user_id', auth()->id())->where('event_id', $event->id)->exists();
                        $total = \App\Models\Registration::where('event_id', $event->id)->count();
                        $enListaEspera = \App\Models\Waitlist::where('user_id', auth()->id())->where('event_id', $event->id)->exists();
                    @endphp

                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 flex flex-col overflow-hidden group">
                        
                        {{-- PORTADA --}}
                        <div class="h-48 bg-gradient-to-br from-emerald-600 to-teal-900 relative">
                            @if($event->image)
                                <img src="/event-image/{{ $event->id }}" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity">
                            @endif

                            {{-- Lugar (Flotante Abajo) --}}
                            <span class="absolute bottom-3 left-3 px-3 py-1.5 bg-white/95 dark:bg-gray-900/95 backdrop-blur text-emerald-700 dark:text-emerald-400 text-xs font-black uppercase tracking-wider rounded-lg shadow-sm">
                                📍 {{ $event->location ?? $event->space?->name }}
                            </span>

                            {{-- Botón Favoritos (Flotante Arriba Derecha) --}}
                            <div class="absolute top-3 right-3">
                                <form method="POST" action="/events/{{ $event->id }}/favorite">
                                    @csrf
                                    @if($favorito) @method('DELETE') @endif
                                    <button class="p-2.5 bg-black/30 hover:bg-black/50 rounded-full backdrop-blur-md transition-colors" title="{{ $favorito ? 'Quitar de favoritos' : 'Agregar a favoritos' }}">
                                        @if($favorito)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 fill-current" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- CUERPO DE LA TARJETA --}}
                        <div class="p-5 flex-1 flex flex-col">
                            
                            {{-- Título y Autor --}}
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white leading-tight mb-1 group-hover:text-emerald-600 transition-colors">
                                {{ $event->title }}
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
                                Por: <span class="font-semibold">{{ $event->user->name }}</span>
                            </p>

                            {{-- Categorías --}}
                            @if($event->categories->count())
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach($event->categories as $category)
                                        <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 rounded-md">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Descripción --}}
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-6 line-clamp-2">
                                {{ $event->description }}
                            </p>

                            {{-- Detalles (Fecha y Capacidad) --}}
                            <div class="space-y-2 mt-auto">
                                <div class="flex items-center text-sm font-medium text-gray-600 dark:text-gray-300">
                                    <span class="text-emerald-500 mr-2 text-lg">📅</span>
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y, h:i A') }}
                                </div>
                                <div class="flex items-center text-sm font-medium text-gray-600 dark:text-gray-300">
                                    <span class="text-emerald-500 mr-2 text-lg">👥</span>
                                    @if(($event->space && $event->space->is_unlimited) || is_null($event->capacity))
                                        Cupo Ilimitado
                                    @else
                                        {{ $total }} / {{ $event->capacity }} inscritos
                                    @endif
                                </div>
                            </div>

                        </div>

                        {{-- PIE DE TARJETA (Acciones) --}}
                        <div class="p-5 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 flex items-center justify-between">
                            
                            <a href="/events/{{ $event->id }}" class="text-sm font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 transition-colors">
                                Ver detalle &rarr;
                            </a>

                            {{-- Lógica de Botones de Inscripción --}}
                            <div>
                                @if($inscrito)
                                    <form method="POST" action="/events/{{ $event->id }}/unregister">
                                        @csrf @method('DELETE')
                                        <button class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-bold rounded-xl transition-colors">
                                            Cancelar
                                        </button>
                                    </form>

                                @elseif($enEspera)
                                    <form method="POST" action="/events/{{ $event->id }}/waitlist">
                                        @csrf @method('DELETE')
                                        <button class="px-4 py-2 bg-orange-100 hover:bg-orange-200 text-orange-700 text-sm font-bold rounded-xl transition-colors">
                                            Salir de espera
                                        </button>
                                    </form>

                                @elseif(!is_null($event->capacity) && !$event->space?->is_unlimited && $total >= $event->capacity)
                                    <form method="POST" action="/events/{{ $event->id }}/waitlist">
                                        @csrf
                                        <button class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-green shadow-sm text-sm font-bold rounded-xl transition-colors">
                                            Lista de espera
                                        </button>
                                    </form>

                                @else
                                    <form method="POST" action="/events/{{ $event->id }}/register">
                                        @csrf
                                        <button class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white shadow-md text-sm font-bold rounded-xl transition-transform transform hover:-translate-y-0.5">
                                            Inscribirme
                                        </button>
                                    </form>
                                @endif
                            </div>

                        </div>

                    </div>

                {{-- ESTADO VACÍO --}}
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-24 text-center">
                        <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-full mb-5 shadow-inner">
                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-gray-800 dark:text-white">
                            No hay eventos disponibles
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">
                            Intenta cambiar el filtro o vuelve más tarde.
                        </p>
                    </div>
                @endforelse

            </div>

        </div>
    </div>
</x-app-layout>