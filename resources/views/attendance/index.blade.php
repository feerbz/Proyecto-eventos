<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tighter">
            Control de <span class="text-emerald-600">Asistencia</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="space-y-4">
                @forelse($events as $event)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 flex items-center justify-between transition-all hover:border-emerald-500">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">
                                {{ $event->title }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                                📅 {{ $event->event_date }}
                            </p>
                        </div>

                        <a href="/events/{{ $event->id }}/attendance"
                           class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/20 transition-transform transform hover:-translate-y-0.5">
                            Ver registro
                        </a>
                    </div>
                @empty
                    <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Sin eventos hoy</h3>
                        <p class="text-gray-500 dark:text-gray-400">No hay eventos programados para registrar asistencia.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>