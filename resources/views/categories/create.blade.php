<x-app-layout>

    <div class="max-w-2xl mx-auto p-6">

        <h2 class="text-2xl font-bold mb-6">
            Crear Categoría
        </h2>

        <form method="POST" action="/categories">

            @csrf

            <div class="mb-4">

                <label class="block mb-1">
                    Nombre
                </label>

                <input
                    type="text"
                    name="name"
                    class="w-full rounded-xl border-gray-300">

            </div>

            <button
                class="bg-emerald-600 text-white px-5 py-2 rounded-xl">

                Guardar

            </button>

        </form>

    </div>

</x-app-layout>