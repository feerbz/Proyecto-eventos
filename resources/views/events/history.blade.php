<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tighter">
            Historial de <span class="text-emerald-600">Participación</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        
                        {{-- CABECERA DE LA TABLA --}}
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-900/50 text-gray-600 dark:text-gray-400 text-sm uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                                <th class="px-6 py-4 font-bold">Evento</th>
                                <th class="px-6 py-4 font-bold">Fecha</th>
                                <th class="px-6 py-4 font-bold text-center">Estado</th>
                            </tr>
                        </thead>

                        {{-- CUERPO DE LA TABLA --}}
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            
                            {{-- EVENTOS INSCRITOS / PASADOS --}}
                            @foreach($registrations as $registration)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                                    
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900 dark:text-white text-base group-hover:text-emerald-600 transition-colors">
                                            {{ $registration->event->title }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-600 dark:text-gray-300 flex items-center">
                                            <span class="mr-2 opacity-50 text-emerald-500">📅</span>
                                            {{ \Carbon\Carbon::parse($registration->event->event_date)->format('d M Y, h:i A') }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        @if(\Carbon\Carbon::parse($registration->event->event_date)->isPast())
                                            {{-- Badge: Participó (Azul) --}}
                                            <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-bold uppercase tracking-wide bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full border border-blue-200 dark:border-blue-800">
                                                Participó
                                            </span>
                                        @else
                                            {{-- Badge: Inscrito (Verde) --}}
                                            <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-bold uppercase tracking-wide bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-full border border-emerald-200 dark:border-emerald-800">
                                                Inscrito
                                            </span>
                                        @endif
                                    </td>
                                    
                                </tr>
                            @endforeach

                            {{-- EVENTOS EN LISTA DE ESPERA --}}
                            @foreach($waitlists as $wait)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                                    
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900 dark:text-white text-base group-hover:text-emerald-600 transition-colors">
                                            {{ $wait->event->title }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-600 dark:text-gray-300 flex items-center">
                                            <span class="mr-2 opacity-50 text-emerald-500">📅</span>
                                            {{ \Carbon\Carbon::parse($wait->event->event_date)->format('d M Y, h:i A') }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        {{-- Badge: Lista de espera (Naranja) --}}
                                        <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-bold uppercase tracking-wide bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400 rounded-full border border-orange-200 dark:border-orange-800">
                                            Lista de espera
                                        </span>
                                    </td>
                                    
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    {{-- MENSAJE DE ESTADO VACÍO --}}
                    @if($registrations->isEmpty() && $waitlists->isEmpty())
                        <div class="flex flex-col items-center justify-center py-16 text-center">
                            <div class="bg-gray-100 dark:bg-gray-800 p-5 rounded-full mb-4 shadow-inner">
                                <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                Sin historial aún
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                                Tus eventos inscritos aparecerán aquí.
                            </p>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>