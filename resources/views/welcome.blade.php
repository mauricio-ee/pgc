<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'EcoVenta - Alimentos Orgánicos') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-white">
        <header class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="text-2xl font-extrabold text-green-700 tracking-tight">EcoVenta <span aria-hidden="true">🌱</span></a>
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-green-600 px-3 py-2">Ir a mi Panel</a>
                        @else
                            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-green-600 px-3 py-2">Iniciar Sesión</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="font-bold bg-green-600 text-white px-5 py-2.5 rounded-lg hover:bg-green-700 transition shadow-md">Únete Gratis</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        <main>
            <section class="pt-32 pb-20 lg:pt-48 lg:pb-32 px-4 sm:px-6 lg:px-8 text-center bg-gradient-to-b from-green-50 to-white">
                <div class="max-w-5xl mx-auto">
                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-green-700 mb-5">Comercio local y sostenible</p>
                    <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight text-gray-900 mb-8 leading-tight">Alimentos cultivados con <span class="text-green-600">respeto por la tierra</span></h1>
                    <p class="text-xl text-gray-600 mb-10 max-w-3xl mx-auto leading-relaxed">Conectamos agricultores locales sostenibles con consumidores que cuidan su salud y el planeta.</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-green-600 text-white rounded-lg font-bold text-lg hover:bg-green-700 hover:shadow-lg transition">Soy agricultor</a>
                        <a href="{{ route('products.index') }}" class="px-8 py-4 bg-white text-green-700 border-2 border-green-600 rounded-lg font-bold text-lg hover:bg-green-50 transition">Explorar productos</a>
                    </div>
                </div>
            </section>

            <section class="py-20 bg-green-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Una compra que importa</h2>
                        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Apoya a productores locales y elige alimentos cultivados de forma responsable.</p>
                    </div>
                    <div class="grid md:grid-cols-3 gap-10">
                        <div class="bg-white rounded-xl p-8 shadow-sm border border-green-100"><div class="text-3xl mb-6" aria-hidden="true">❤️</div><h3 class="text-xl font-bold text-gray-900 mb-3">Más salud</h3><p class="text-gray-600">Productos frescos para cuidar tu alimentación cada día.</p></div>
                        <div class="bg-white rounded-xl p-8 shadow-sm border border-green-100"><div class="text-3xl mb-6" aria-hidden="true">🚜</div><h3 class="text-xl font-bold text-gray-900 mb-3">Directo del campo</h3><p class="text-gray-600">Compra a agricultores locales sin intermediarios innecesarios.</p></div>
                        <div class="bg-white rounded-xl p-8 shadow-sm border border-green-100"><div class="text-3xl mb-6" aria-hidden="true">🌍</div><h3 class="text-xl font-bold text-gray-900 mb-3">Impacto positivo</h3><p class="text-gray-600">Favorece prácticas sostenibles y comunidades más fuertes.</p></div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-white border-t border-gray-200 py-12">
            <div class="max-w-7xl mx-auto px-4 text-center text-gray-500">
                <p>&copy; {{ date('Y') }} EcoVenta. Comercio justo y verde.</p>
                <div class="mt-4 flex justify-center gap-6"><a href="#" class="hover:text-green-600">Términos de servicio</a><a href="#" class="hover:text-green-600">Privacidad</a><a href="#" class="hover:text-green-600">Soporte</a></div>
            </div>
        </footer>
        <x-cookies-banner />
        <x-chatbot />
    </body>
</html>
