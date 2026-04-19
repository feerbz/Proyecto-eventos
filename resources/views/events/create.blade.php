<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Nuevo Evento') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    
                    <div class="mb-8">
                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white">Detalles del Evento</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Llena la información para publicar el evento en la comunidad de la UPIICSA.</p>
                    </div>

                    <form method="POST" action="/events" class="space-y-6">
                        @csrf 

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Título del Evento *</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-colors"
                                    placeholder="Ej. Torneo de Voleibol">
                                @error('title')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="capacity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Capacidad (Cupo) *</label>
                                <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}" 
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-colors"
                                    placeholder="Ej. 50">
                                @error('capacity')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="event_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha y Hora *</label>
                                <input type="datetime-local" name="event_date" id="event_date" value="{{ old('event_date') }}"
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-colors">
                                @error('event_date')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lugar</label>
                                <input type="text" name="location" id="location" value="{{ old('location') }}"
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-colors"
                                    placeholder="Ej. Edificio Cultural">
                                @error('location')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción del Evento *</label>
                            <textarea name="description" id="description" rows="4" 
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-colors"
                                placeholder="Describe de qué trata el evento...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100 dark:border-gray-700 mt-6">
                            <a href="/dashboard" class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                                Cancelar
                            </a>
                            <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-emerald-600 border border-transparent rounded-xl hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all shadow-md shadow-emerald-500/30">
                                Crear evento
                            </button>
                        </div>
                    </form>

                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>