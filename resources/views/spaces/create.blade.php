<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 dark:text-white tracking-tighter">
            Crear <span class="text-emerald-600">Espacio</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700">
                <form method="POST" action="/spaces" class="space-y-6">
                    @csrf

                    {{-- Nombre --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nombre del espacio</label>
                        <input type="text" name="name" placeholder="Ej. Auditorio A" required
                               class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-colors">
                    </div>

                    {{-- Capacidad --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Capacidad</label>
                        <input type="number" name="capacity" id="capacityInput" placeholder="Ej. 100"
                               class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-colors disabled:bg-gray-100 disabled:cursor-not-allowed">
                    </div>

                    {{-- Checkbox --}}
                    <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <input type="checkbox" name="is_unlimited" id="unlimitedCheck"
                               class="w-5 h-5 text-emerald-600 rounded focus:ring-emerald-500 border-gray-300">
                        <label for="unlimitedCheck" class="text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-pointer">
                            Sin límite de capacidad
                        </label>
                    </div>

                    {{-- Botón --}}
                    <div class="flex justify-end pt-4">
                        <button type="submit" 
                                class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-md transition-transform transform hover:-translate-y-0.5 focus:ring-4 focus:ring-emerald-500 focus:ring-opacity-50">
                            Guardar espacio
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        const check = document.getElementById('unlimitedCheck');
        const capacity = document.getElementById('capacityInput');

        function updateCapacity() {
            if (check.checked) {
                capacity.value = '';
                capacity.disabled = true;
            } else {
                capacity.disabled = false;
            }
        }

        check.addEventListener('change', updateCapacity);
    </script>
</x-app-layout>