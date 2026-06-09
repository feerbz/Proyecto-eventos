<x-app-layout>

    <div class="max-w-2xl mx-auto p-6">

        <h2 class="text-2xl font-bold mb-6">
            Editar Espacio
        </h2>

        <form
            method="POST"
            action="/spaces/{{ $space->id }}"
            class="space-y-6">

            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">
                    Nombre
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ $space->name }}"
                    class="w-full rounded-xl border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Capacidad
                </label>

                <input
                    type="number"
                    name="capacity"
                    id="capacityInput"
                    value="{{ $space->capacity }}"
                    class="w-full rounded-xl border-gray-300">
            </div>

            <div class="flex items-center gap-2">

                <input
                    type="checkbox"
                    name="is_unlimited"
                    id="unlimitedCheck"
                    {{ $space->is_unlimited ? 'checked' : '' }}>

                <label for="unlimitedCheck">
                    Sin límite de capacidad
                </label>

            </div>

            <button
                class="bg-emerald-600 text-white px-5 py-2 rounded-xl">

                Guardar cambios

            </button>

        </form>

    </div>

</x-app-layout>

<script>

const check =
    document.getElementById('unlimitedCheck');

const capacity =
    document.getElementById('capacityInput');

function updateCapacity() {

    if (check.checked) {

        capacity.value = '';
        capacity.disabled = true;

    } else {

        capacity.disabled = false;
    }
}

check.addEventListener('change', updateCapacity);

updateCapacity();

</script>