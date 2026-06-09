<x-app-layout>
    @if(session('error'))
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif


    <div class="max-w-5xl mx-auto p-6">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">
                Espacios
            </h2>

            <a href="/spaces/create"
                class="bg-emerald-600 text-white px-4 py-2 rounded-xl">
                Nuevo espacio
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border">

            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2">Nombre</th>
                    <th class="p-2">Capacidad</th>
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>

            <tbody>

            @foreach($spaces as $space)

                <tr class="border-t">

                    <td class="p-2">
                        {{ $space->name }}
                    </td>

                    <td class="p-2">
                        {{ $space->is_unlimited ? 'ILIMITADO' : $space->capacity }}
                    </td>

                    <td class="p-2">
                        <div class="flex gap-2">

<a
    href="/spaces/{{ $space->id }}/edit"
    class="bg-blue-500 px-3 py-1 rounded font-bold green !text-green">
    Editar
</a>

        <form
            method="POST"
            action="/spaces/{{ $space->id }}"
            onsubmit="return confirm('¿Eliminar espacio?')">

            @csrf
            @method('DELETE')

            <button
                class="bg-red-500 text-white px-3 py-1 rounded">

                Eliminar

            </button>

        </form>

    </div>
</td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</x-app-layout>