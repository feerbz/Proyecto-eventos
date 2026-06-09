<x-app-layout>
    <x-slot name="header">
        @if (session('error'))
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Evento') }} <span class="text-emerald-600">#{{ $event->id }}</span>
            </h2>
            <a href="/mis-eventos" class="text-sm text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400 transition-colors font-bold">
                ← Volver a mis eventos
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    
                    <div class="mb-8 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Actualizar Información</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Revisa y modifica los detalles de tu evento a continuación.</p>
                    </div>

                    <form method="POST"
      action="/events/{{ $event->id }}"
      enctype="multipart/form-data"
      class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="title" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Título del Evento</label>
                            <input type="text" id="title" name="title" value="{{ $event->title }}" required placeholder="Ej. Conferencia de Tecnología"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                            <textarea id="description" name="description" rows="4" required placeholder="Describe de qué trata el evento..."
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors">{{ $event->description }}</textarea>
</div>


    <div>
    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">
        Espacio
    </label>

    <select
        name="space_id"
        id="spaceSelect"
        class="w-full rounded-xl border-gray-300 dark:bg-gray-900">

        <option value="">Selecciona un espacio</option>

        @foreach($spaces as $space)
            <option
                value="{{ $space->id }}"
                data-capacity="{{ $space->capacity }}"
                data-unlimited="{{ $space->is_unlimited ? '1' : '0' }}"
                {{ old('space_id', $event->space_id) == $space->id ? 'selected' : '' }}
            >
                {{ $space->name }}
            </option>
        @endforeach

        <option
    value="other"
    {{
        old('space_id')
            ? (old('space_id') === 'other' ? 'selected' : '')
            : (!$event->space_id && $event->location ? 'selected' : '')
    }}
>
    Otro (especificar)
</option>

    </select>
    <div
    id="customLocationField"
    style="{{ (!$event->space_id && $event->location) ? '' : 'display:none;' }}"
>
    <label class="block text-sm font-medium">
        Lugar
    </label>

    <input
        type="text"
        name="location"
        value="{{ old('location', $event->location) }}"
        class="w-full rounded-xl border-gray-300 dark:bg-gray-900">
</div>
</div>
<div class="w-full md:w-1/2">
    <label for="capacity"
        class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">
        Capacidad Máxima
    </label>

    <input
    type="number"
    id="capacityInput"
    name="capacity"
        value="{{ old('capacity', $event->capacity) }}"
        min="1"
        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
</div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="event_date" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Fecha y Hora</label>
                                <input type="datetime-local" id="event_date" name="event_date" 
                                    value="{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i') }}" required
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors">
                            </div>
                        </div>
                        <div>
    <label
        class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">

        Hora de fin
    </label>

    <input
        type="time"
        name="end_time"
        value="{{ $event->end_time }}"
        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
</div>

</div>
<div>
    <label class="block text-sm font-medium">
        Categorías
    </label>

    <div class="space-y-2 mt-2">

        @foreach($categories as $category)

            <label class="flex items-center gap-2">

                <input
                    type="checkbox"
                    name="categories[]"
                    value="{{ $category->id }}"
                    {{ $event->categories->contains($category->id) ? 'checked' : '' }}
                >

                {{ $category->name }}

            </label>

        @endforeach

    </div>
</div>

<div>
    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">
        Nueva imagen
    </label>

    <input
        type="file"
        name="image"
        accept="image/*"
        class="w-full rounded-xl border-gray-300 dark:bg-gray-900">
</div>


                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100 dark:border-gray-700 mt-8">
                            <a href="/mis-eventos" class="px-4 py-2 text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                                Cancelar
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white font-bold text-sm rounded-xl hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-500/30 transition-all shadow-md shadow-emerald-500/20">
                                Actualizar
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function () {

    const spaceSelect = document.getElementById('spaceSelect');
    const capacityInput = document.getElementById('capacityInput');
    const customField = document.getElementById('customLocationField');

    function updateFields() {

        let selectedOption =
            spaceSelect.options[spaceSelect.selectedIndex];

        let capacity =
            selectedOption.getAttribute('data-capacity');

        let unlimited =
            selectedOption.getAttribute('data-unlimited');

if (spaceSelect.value === 'other') {

    customField.style.display = 'block';

    capacityInput.removeAttribute('readonly');

}
else if (spaceSelect.value === '') {

    customField.style.display = 'none';

    capacityInput.value = '';
    capacityInput.placeholder = '';
    capacityInput.removeAttribute('readonly');
}

        else {

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
});
</script>
</x-app-layout>