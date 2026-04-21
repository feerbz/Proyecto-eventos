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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse ($events as $event)

                    @php
                        $inscrito = \App\Models\Registration::where('user_id', auth()->id())
                            ->where('event_id', $event->id)
                            ->exists();

                        $total = \App\Models\Registration::where('event_id', $event->id)->count();
                    @endphp

                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex flex-col transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-500/10">

                        <span class="inline-block px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-[10px] font-extrabold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest w-max mb-4">
                            {{ $event->location }}
                        </span>

                        <h3 class="text-lg font-black text-gray-900 dark:text-white mb-2">
                            {{ $event->title }}
                        </h3>

                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3 flex-grow line-clamp-3">
                            {{ $event->description }}
                        </p>

                        <a href="/events/{{ $event->id }}" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 font-bold text-sm inline-flex items-center gap-1 mb-6 transition-colors w-max">
                            Ver detalles completos
                            <span aria-hidden="true">&rarr;</span>
                        </a>

                        <p class="text-sm mb-2 text-gray-700 dark:text-gray-300 font-medium">
                            📅 {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y h:i A') }}
                        </p>

                        <p class="text-sm mb-6 text-emerald-600 dark:text-emerald-400 font-bold">
                            👥 Cupo: {{ $total }} / {{ $event->capacity }}
                        </p>

                        <div class="mt-auto border-t border-gray-100 dark:border-gray-700 pt-4">
                            @if($inscrito)

                                <div class="text-center mb-2">
                                    <span class="inline-block bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 px-3 py-1 rounded-full text-xs font-bold w-full">
                                        ✓ Ya estás inscrito
                                    </span>
                                </div>

                                <form method="POST" action="/events/{{ $event->id }}/unregister">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-full bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-500 hover:text-white dark:hover:bg-red-600 dark:hover:text-white font-bold text-sm py-2.5 rounded-xl transition-colors border border-red-200 dark:border-red-800/50"
                                        onclick="return confirm('¿Seguro que deseas cancelar tu inscripción a este evento?')">
                                        Cancelar inscripción
                                    </button>
                                </form>

                            @elseif($total >= $event->capacity)

                                <button disabled class="w-full bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 font-bold text-sm py-2.5 rounded-xl cursor-not-allowed">
                                    Evento lleno
                                </button>

                            @else

                                <form method="POST" action="/events/{{ $event->id }}/register">
                                    @csrf
                                    <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black text-sm py-2.5 rounded-xl shadow-md active:scale-[0.98] transition-all">
                                        Inscribirme
                                    </button>
                                </form>

                            @endif
                        </div>

                    </div>

                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                        <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-full mb-4">
                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">No hay eventos disponibles</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2">Vuelve más tarde para ver las novedades.</p>
                    </div>
                @endforelse

            </div>

        </div>
    </div>
</x-app-layout>