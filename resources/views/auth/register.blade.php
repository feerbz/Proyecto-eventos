<x-guest-layout>
    <div class="flex justify-center mb-8 select-none">
        <h1 class="text-5xl font-black tracking-tighter text-gray-900 dark:text-white">
            Uni<span class="text-emerald-500">Event.</span>
        </h1>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                placeholder="ejemplo@correo.com"
                required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="phone" :value="'Teléfono'" />
            <x-text-input 
                id="phone" 
                class="block mt-1 w-full" 
                type="text" 
                name="phone" 
                :value="old('phone')" 
                required 
                autocomplete="tel" 
            />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="role" :value="'Rol'" />
            <select
                id="role"
                name="role"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                required
            >
                <option value="organizer" {{ old('role') == 'organizer' ? 'selected' : '' }}>
                    Organizador
                </option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                    Administrador
                </option>
            </select>

            <p id="adminWarning" class="hidden mt-2 text-sm text-red-600 dark:text-red-400">
                Los privilegios de administrador son asignados únicamente por un administrador del sistema. Si requieres este rol, comunícate con un administrador.
            </p>

            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4" id="registerButton">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const role = document.getElementById('role');
            const warning = document.getElementById('adminWarning');
            const button = document.getElementById('registerButton');

            function checkRole() {
                if (role.value === 'admin') {
                    warning.classList.remove('hidden');
                    button.disabled = true;
                    button.classList.add('opacity-50', 'cursor-not-allowed');
                    button.innerHTML = 'Contactar administrador';
                } else {
                    warning.classList.add('hidden');
                    button.disabled = false;
                    button.classList.remove('opacity-50', 'cursor-not-allowed');
                    button.innerHTML = 'Register';
                }
            }

            role.addEventListener('change', checkRole);
            checkRole();
        });
    </script>
</x-guest-layout>