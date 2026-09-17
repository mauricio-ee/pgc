<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-800 leading-tight">
            Panel de Inicio
        </h2>
    </x-slot>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-green-800 via-green-700 to-emerald-600 text-white py-16 md:py-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">
                        ¡Bienvenido de vuelta! 🌿
                    </h1>
                    <p class="text-green-100 text-lg mb-6">
                        Explora productos sostenibles de comerciantes locales o gestiona tus ventas
                    </p>
                    <div class="flex gap-4 flex-wrap">
                        <a href="{{ route('products.index') }}" class="inline-block bg-white text-green-700 font-bold py-3 px-8 rounded-lg hover:bg-green-50 transition-transform hover:scale-105">
                            Ver Catálogo
                        </a>
                        <a href="{{ route('orders.index') }}" class="inline-block bg-green-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-green-500 transition-transform hover:scale-105 border-2 border-white">
                            Mis Pedidos
                        </a>
                    </div>
                </div>
                <div class="text-6xl md:text-8xl opacity-20 md:opacity-30">
                    🍃
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Orders -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-2">Tus Pedidos</p>
                            <h3 class="text-3xl font-bold text-green-700">
                                {{ $orders_count ?? 0 }}
                            </h3>
                        </div>
                        <div class="text-4xl">📦</div>
                    </div>
                    <a href="{{ route('orders.index') }}" class="text-green-600 text-sm font-medium hover:underline mt-4 inline-block">
                        Ver detalles →
                    </a>
                </div>

                <!-- Wishlist Items -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-2">Favoritos Guardados</p>
                            <h3 class="text-3xl font-bold text-green-700">
                                0
                            </h3>
                        </div>
                        <div class="text-4xl">❤️</div>
                    </div>
                    <p class="text-gray-500 text-xs mt-4">
                        Próximamente disponible
                    </p>
                </div>

                <!-- Sustainability Points -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-2">Puntos Eco</p>
                            <h3 class="text-3xl font-bold text-green-700">
                                {{ ($orders_count ?? 0) * 10 }}
                            </h3>
                        </div>
                        <div class="text-4xl">🌍</div>
                    </div>
                    <p class="text-gray-500 text-xs mt-4">
                        Acumula puntos por tus compras sostenibles
                    </p>
                </div>
            </div>

            <!-- Welcome Message -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 border border-green-200">
                <h2 class="text-2xl font-bold text-green-900 mb-3">
                    ✨ Sobre Ecoventa
                </h2>
                <p class="text-green-800 leading-relaxed mb-4">
                    Bienvenido a Ecoventa, una plataforma comprometida con el comercio sostenible y local. 
                    Aquí encontrarás productos de alta calidad de comerciantes que comparten nuestros valores 
                    de sostenibilidad y responsabilidad ambiental.
                </p>
                <ul class="space-y-2 text-green-800">
                    <li class="flex items-center gap-2">
                        <span class="text-lg">🌱</span>
                        <span>Productos 100% sostenibles verificados</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-lg">👥</span>
                        <span>Apoyo directo a comerciantes locales</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-lg">🌍</span>
                        <span>Reducción de huella de carbono en cada compra</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Recent Products Section (Optional) -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">
                Productos Destacados
            </h2>
            <p class="text-gray-600 mb-8">
                <a href="{{ route('products.index') }}" class="text-green-600 font-semibold hover:underline">
                    Explora el catálogo completo →
                </a>
            </p>
        </div>
    </div>
</x-app-layout>

