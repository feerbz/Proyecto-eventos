<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tighter">
                    Mis <span class="text-emerald-600">Inscripciones</span>
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                    Los eventos en los que ya tienes tu lugar asegurado.
                </p>
            </div>
            
            <a href="/dashboard" class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-300 text-sm font-bold rounded-xl transition-all shadow-sm active:scale-95">
                Volver a la Cartelera
            </a>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-6">
            <div class="bg-emerald-50 dark:bg-emerald-900/30 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm">
                <p class="text-emerald-800 dark:text-emerald-300 font-bold text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse ($registrations as $reg)

                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-emerald-100 dark:border-emerald-900/50 p-6 flex flex-col relative overflow-hidden transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-500/10">

                        <div class="absolute top-0 left-0 w-full h-1.5 bg-emerald-500"></div>

                        <span class="inline-block px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-[10px] font-extrabold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest w-max mb-4 mt-2">
                            {{ $reg->event->location }}
                        </span>

                        <h3 class="text-lg font-black text-gray-900 dark:text-white mb-2">
                            {{ $reg->event->title }}
                        </h3>

                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 flex-grow line-clamp-2">
                            {{ $reg->event->description }}
                        </p>

                        <p class="text-sm mb-6 text-gray-700 dark:text-gray-300 font-medium bg-gray-50 dark:bg-gray-900/50 p-3 rounded-lg border border-gray-100 dark:border-gray-700">
                            📅 {{ \Carbon\Carbon::parse($reg->event->event_date)->format('d M Y - h:i A') }}
                        </p>

                        <div class="mt-auto border-t border-gray-100 dark:border-gray-700 pt-4">
                            <form method="POST" action="/events/{{ $reg->event->id }}/unregister">
                                @csrf
                                @method('DELETE')
                                <button class="w-full bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-500 hover:text-white dark:hover:bg-red-600 dark:hover:text-white font-bold text-sm py-2.5 rounded-xl transition-colors border border-red-200 dark:border-red-800/50"
                                    onclick="return confirm('¿Seguro que deseas cancelar tu inscripción a este evento?')">
                                    Cancelar inscripción
                                </button>
                            </form>
                        </div>

                    </div>

                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                        <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-full mb-4">
                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Aún no te has inscrito a nada</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 mb-6">Explora la cartelera y asegura tu lugar en los próximos eventos.</p>
                        <a href="/dashboard" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all shadow-md active:scale-95">
                            Ir a explorar
                        </a>
                    </div>
                @endforelse

            </div>

        </div>
    </div>
</x-app-layout>