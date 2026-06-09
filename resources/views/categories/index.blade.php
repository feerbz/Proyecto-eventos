<x-app-layout>

    <div class="max-w-4xl mx-auto p-6">

        <div class="flex justify-between items-center mb-6">

            <h2 class="text-2xl font-bold">
                Categorías
            </h2>

            <a
                href="/categories/create"
                class="bg-emerald-600 text-white px-4 py-2 rounded-xl">

                Nueva categoría

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
                    <th class="p-2">Acciones</th>
                </tr>

            </thead>

            <tbody>

            @foreach($categories as $category)

                <tr class="border-t">

                    <td class="p-2">
                        {{ $category->name }}
                    </td>

                    <td class="p-2">

                        <form
                            method="POST"
                            action="/categories/{{ $category->id }}"
                            onsubmit="return confirm('¿Eliminar categoría?')">

                            @csrf
                            @method('DELETE')

                            <button
                                class="bg-red-500 text-white px-3 py-1 rounded">

                                Eliminar

                            </button>

                        </form>

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</x-app-layout>