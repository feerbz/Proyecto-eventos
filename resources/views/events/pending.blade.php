<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tighter">
                Panel de <span class="text-amber-500">Aprobación</span>
            </h2>
            <span class="px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-bold rounded-full uppercase tracking-widest border border-amber-200 dark:border-amber-700/50">
                Admin Mode
            </span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-[2rem] border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    
                    <div class="mb-8 border-b border-gray-100 dark:border-gray-700 pb-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Solicitudes Pendientes</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Revisa y gestiona los eventos propuestos por la comunidad estudiantil.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-700">
                                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Evento</th>
                                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest">Descripción</th>
                                    <th class="py-4 px-4 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                                
                                @forelse ($events as $event)
                                    <tr class="group hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                        <td class="py-6 px-4">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-gray-900 dark:text-white group-hover:text-amber-500 transition-colors">
                                                    {{ $event->title }}
                                                </span>
                                            </div>
                                        </td>
                                        
                                        <td class="py-6 px-4 text-sm text-gray-600 dark:text-gray-400 font-medium max-w-md">
                                            <p class="line-clamp-2" title="{{ $event->description }}">
                                                {{ $event->description }}
                                            </p>
                                        </td>
                                        
                                        <td class="py-6 px-4">
                                            <div class="flex items-center justify-center gap-3">
                                                <form method="POST" action="/events/{{ $event->id }}/approve">
                                                    @csrf
                                                    <button type="submit" class="p-2 bg-emerald-100 dark:bg-emerald-900/30 hover:bg-emerald-500 text-emerald-600 dark:text-emerald-400 hover:text-white rounded-lg transition-all active:scale-95 shadow-sm shadow-emerald-200 dark:shadow-none" title="Aprobar Evento">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                    </button>
                                                </form>

                                                <form method="POST" action="/events/{{ $event->id }}/reject">
                                                    @csrf
                                                    <button type="submit" class="p-2 bg-rose-100 dark:bg-rose-900/30 hover:bg-rose-500 text-rose-600 dark:text-rose-400 hover:text-white rounded-lg transition-all active:scale-95 shadow-sm shadow-rose-200 dark:shadow-none" title="Rechazar Evento">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-20 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-full mb-4 border border-gray-100 dark:border-gray-600">
                                                    <svg class="w-10 h-10 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                </div>
                                                <p class="text-gray-500 dark:text-gray-400 font-medium tracking-tight">Todo al día. No hay solicitudes pendientes por revisar.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>