<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-800 leading-tight">
            ¡Bienvenido a Ecoventa! 🌱
        </h2>
    </x-slot>

    <div class="py-12 bg-[#ebebeb] min-h-screen flex items-center justify-center">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 w-full">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-green-100 text-center py-16 px-10">
                
                <div class="mx-auto w-24 h-24 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-5xl mb-6 shadow-sm">
                    🎉
                </div>

                <h1 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">¡Registro Exitoso, {{ Auth::user()->name }}!</h1>
                
                <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto leading-relaxed">
                    Tu cuenta ha sido creada correctamente. Ahora eres parte de nuestra comunidad ecológica. 
                    @if(Auth::user()->isSeller())
                        Ya puedes empezar a publicar los productos de tu huerto y llegar a miles de clientes.
                    @else
                        Ya puedes explorar el catálogo y apoyar a los agricultores locales con tus compras.
                    @endif
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    @if(Auth::user()->isSeller())
                        <a href="{{ route('seller.productos.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition transform hover:-translate-y-1">
                            Ir a Mi Granja
                        </a>
                    @else
                        <a href="{{ route('products.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition transform hover:-translate-y-1">
                            Explorar Catálogo
                        </a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-3 px-8 rounded-lg shadow-sm border border-gray-200 transition">
                        Ver Mi Perfil
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
