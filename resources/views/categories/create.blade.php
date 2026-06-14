<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tighter">
            Nueva <span class="text-emerald-600">Categoría</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700">
                <form method="POST" action="/categories" class="space-y-6">
                    @csrf

                    {{-- Nombre --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nombre de la categoría</label>
                        <input type="text" name="name" placeholder="Ej. Académico" required
                               class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-colors">
                    </div>

                    {{-- Botón --}}
                    <div class="flex justify-end pt-4">
                        <button type="submit" 
                                class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-md transition-transform transform hover:-translate-y-0.5 focus:ring-4 focus:ring-emerald-500 focus:ring-opacity-50">
                            Guardar categoría
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>