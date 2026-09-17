<x-guest-layout>
    <!-- Mostrar errores generales de validación en una alerta superior -->
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">¡Oops! Hubo un problema.</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nombre Completo" />
            <x-text-input id="name" class="block mt-1 w-full border-green-300 focus:border-green-500 focus:ring-green-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" value="Correo Electrónico" />
            <x-text-input id="email" class="block mt-1 w-full border-green-300 focus:border-green-500 focus:ring-green-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role / Tipo de Cuenta -->
        <div class="mt-4">
            <x-input-label for="role" value="¿Qué tipo de cuenta deseas crear?" />
            <select id="role" name="role" required class="block mt-1 w-full border-green-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Selecciona una opción</option>
                <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Cliente (Quiero comprar productos)</option>
                <option value="seller" {{ old('role') === 'seller' ? 'selected' : '' }}>Vendedor (Quiero vender mi cosecha)</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Contraseña" />

            <x-text-input id="password" class="block mt-1 w-full border-green-300 focus:border-green-500 focus:ring-green-500"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmar Contraseña" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full border-green-300 focus:border-green-500 focus:ring-green-500"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-green-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" href="{{ route('login') }}">
                ¿Ya estás registrado?
            </a>

            <x-primary-button class="ms-4 bg-green-700 hover:bg-green-800 focus:bg-green-800 active:bg-green-900 border border-transparent focus:ring-green-500">
                Registrarse
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

