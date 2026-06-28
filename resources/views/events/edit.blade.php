<x-app-layout>
    <x-slot name="header">
        @if (session('error'))
            <div class="bg-red-500/10 text-red-500 border border-red-500/20 p-3 rounded-lg mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                {{ __('Editar Evento') }} <span class="text-emerald-500">#{{ $event->id }}</span>
            </h2>
            <a href="/mis-eventos" class="text-sm font-bold text-slate-500 hover:text-emerald-500 dark:text-slate-400 transition-colors">
                ← Volver a mis eventos
            </a>
        </div>
    </x-slot>

    <!-- Contenedor principal con fondo oscuro -->
    <div class="py-12 bg-slate-100 dark:bg-[#1a202c] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Tarjeta del Formulario (Estilo Imagen) -->
            <div class="bg-white dark:bg-[#1e293b] shadow-xl sm:rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800">
                <div class="p-8">
                    
                    <form method="POST" action="/events/{{ $event->id }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- 1. Título -->
                        <div>
                            <label for="title" class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Título *</label>
                            <input type="text" id="title" name="title" value="{{ $event->title }}" required placeholder="Ej. Conferencia de Tecnología"
                                class="w-full bg-white dark:bg-[#334155] border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 placeholder-slate-400 dark:placeholder-slate-500 transition-colors">
                        </div>

                        <!-- 2. Fechas -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="event_date" class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Fecha y Hora *</label>
                                <input type="datetime-local" id="event_date" name="event_date" value="{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i') }}" required
                                    class="w-full bg-white dark:bg-[#334155] border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors [color-scheme:light] dark:[color-scheme:dark]">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Hora de fin *</label>
                                <input type="time" name="end_time" value="{{ $event->end_time }}"
                                    class="w-full bg-white dark:bg-[#334155] border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors [color-scheme:light] dark:[color-scheme:dark]">
                            </div>
                        </div>

                        <!-- 3. Espacio y Capacidad -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Espacio</label>
                                <select name="space_id" id="spaceSelect" class="w-full bg-white dark:bg-[#334155] border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                                    <option value="">-- Selecciona un espacio --</option>
                                    @foreach($spaces as $space)
                                        <option value="{{ $space->id }}" data-capacity="{{ $space->capacity }}" data-unlimited="{{ $space->is_unlimited ? '1' : '0' }}" {{ old('space_id', $event->space_id) == $space->id ? 'selected' : '' }}>
                                            {{ $space->name }}
                                        </option>
                                    @endforeach
                                    <option value="other" {{ old('space_id') ? (old('space_id') === 'other' ? 'selected' : '') : (!$event->space_id && $event->location ? 'selected' : '') }}>
                                        Otro (especificar)
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label for="capacity" class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Capacidad</label>
                                <input type="number" id="capacityInput" name="capacity" value="{{ old('capacity', $event->capacity) }}" min="1" placeholder="Selecciona un espacio"
                                    class="w-full bg-white dark:bg-[#334155] border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 placeholder-slate-400 dark:placeholder-slate-500 transition-colors">
                            </div>
                        </div>

                        <!-- 3.5 Campo de Lugar oculto -->
                        <div id="customLocationField" style="{{ (!$event->space_id && $event->location) ? '' : 'display:none;' }}">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Lugar Específico *</label>
                            <input type="text" name="location" value="{{ old('location', $event->location) }}" placeholder="Ej. Auditorio Sur"
                                class="w-full bg-white dark:bg-[#334155] border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        </div>

                        <!-- 4. Descripción -->
                        <div>
                            <label for="description" class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Descripción *</label>
                            <textarea id="description" name="description" rows="5" required placeholder="Escribe los detalles del evento aquí..."
                                class="w-full bg-white dark:bg-[#334155] border border-slate-300 dark:border-slate-600 rounded-lg px-4 py-3 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 placeholder-slate-400 dark:placeholder-slate-500 transition-colors">{{ $event->description }}</textarea>
                        </div>

                        <!-- 5. Categorías (Estilo de cajas) -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-3">Categorías</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($categories as $category)
                                    <label class="flex items-center gap-3 p-3 border border-slate-300 dark:border-slate-600 rounded-lg cursor-pointer hover:bg-slate-50 dark:hover:bg-[#283548] transition-colors">
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ $event->categories->contains($category->id) ? 'checked' : '' }}
                                            class="w-4 h-4 rounded bg-white dark:bg-[#1e293b] border-slate-300 dark:border-slate-600 text-emerald-500 focus:ring-emerald-500 focus:ring-offset-0 dark:focus:ring-offset-[#1e293b]">
                                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- 6. Imagen de Portada (Estilo personalizado punteado) -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Imagen de Portada</label>
                            
                            <div class="border border-dashed border-slate-400 dark:border-slate-600 rounded-lg p-4 flex items-center gap-4 bg-slate-50 dark:bg-transparent">
                                <label class="cursor-pointer px-4 py-2 bg-emerald-100 dark:bg-[#0a3f30] hover:bg-emerald-200 dark:hover:bg-[#0d523e] text-emerald-700 dark:text-emerald-400 text-sm font-medium rounded-md transition-colors">
                                    Seleccionar archivo
                                    <input type="file" name="image" accept="image/*" class="hidden" id="imageInput">
                                </label>
                                <span id="fileName" class="text-sm text-slate-500 dark:text-slate-400">Sin archivos seleccionados</span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-500 mt-2">Formatos permitidos: JPG, PNG.</p>
                        </div>

                        <!-- 7. Alerta de Inscritos (Integrada al diseño oscuro) -->
                        <div class="px-4 py-3 bg-blue-50 dark:bg-[#1e3a5f]/30 border border-blue-200 dark:border-blue-900/50 rounded-lg flex items-center gap-3 mt-6">
                            <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm text-blue-800 dark:text-slate-300">
                                Hay <span class="font-bold text-blue-900 dark:text-blue-400">{{ $event->registrations()->count() }}</span> usuarios inscritos, se les notificaran los cambios
                            </p>
                        </div>

                        <!-- 8. Botón Guardar (Footer con línea separadora) -->
                        <div class="pt-6 border-t border-slate-200 dark:border-slate-700 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-emerald-500 text-white font-bold text-sm rounded-lg hover:bg-emerald-600 focus:ring-4 focus:ring-emerald-500/30 transition-all">
                                Guardar y notificar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT INTACTO + LOGICA DEL BOTON DE ARCHIVO -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // Lógica de Espacios y Capacidad (Original)
            const spaceSelect = document.getElementById('spaceSelect');
            const capacityInput = document.getElementById('capacityInput');
            const customField = document.getElementById('customLocationField');

            function updateFields() {
                let selectedOption = spaceSelect.options[spaceSelect.selectedIndex];
                let capacity = selectedOption.getAttribute('data-capacity');
                let unlimited = selectedOption.getAttribute('data-unlimited');

                if (spaceSelect.value === 'other') {
                    customField.style.display = 'block';
                    capacityInput.removeAttribute('readonly');
                } else if (spaceSelect.value === '') {
                    customField.style.display = 'none';
                    capacityInput.value = '';
                    capacityInput.placeholder = 'Selecciona un espacio';
                    capacityInput.removeAttribute('readonly');
                } else {
                    customField.style.display = 'none';
                    if (unlimited === '1') {
                        capacityInput.value = '';
                        capacityInput.placeholder = 'ILIMITADO';
                        capacityInput.setAttribute('readonly', true);
                    } else {
                        capacityInput.placeholder = '';
                        capacityInput.value = capacity;
                        capacityInput.setAttribute('readonly', true);
                    }
                }
            }

            spaceSelect.addEventListener('change', updateFields);
            updateFields();

            // Lógica Frontend para el botón de archivo (Nuevo)
            const imageInput = document.getElementById('imageInput');
            const fileName = document.getElementById('fileName');

            imageInput.addEventListener('change', function(e) {
                if(e.target.files.length > 0) {
                    fileName.textContent = e.target.files[0].name;
                    fileName.classList.add('text-emerald-500', 'dark:text-emerald-400');
                    fileName.classList.remove('text-slate-500', 'dark:text-slate-400');
                } else {
                    fileName.textContent = 'Sin archivos seleccionados';
                    fileName.classList.remove('text-emerald-500', 'dark:text-emerald-400');
                    fileName.classList.add('text-slate-500', 'dark:text-slate-400');
                }
            });
        });
    </script>
</x-app-layout>