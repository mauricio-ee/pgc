<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <a href="{{ route('products.index') }}" class="text-green-700 hover:text-green-900 font-semibold flex items-center gap-2">
                ← Volver al catálogo
            </a>
            <div class="text-sm text-gray-600">
                {{ $product->category->name ?? 'Productos' }} • {{ $product->user?->name ?? 'Agricultor' }}
            </div>
        </div>
    </x-slot>

    <!-- Hero Section Moderna -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(!$product->user)
                <div class="bg-red-50 border-l-4 border-red-500 p-6 mb-8">
                    <h3 class="text-red-800 font-bold text-lg">⚠️ Producto no disponible</h3>
                    <p class="text-red-700 text-sm mt-2">Este producto ha sido retirado porque el agricultor eliminó su cuenta de EcoVenta.</p>
                </div>
            @endif

            <!-- Grid Asimétrico: Imagen Grande + Detalles -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 py-12">
                
                <!-- Columna Izquierda: Imagen (3 columnas) -->
                <div class="lg:col-span-3">
                    <div class="relative aspect-square bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl overflow-hidden shadow-lg mb-6">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-7xl">🍃</span>
                            </div>
                        @endif

                        @if($product->is_eco_certified)
                            <div class="absolute top-6 right-6 bg-green-500 text-white px-4 py-2 rounded-full font-bold shadow-lg flex items-center gap-2">
                                ✓ Eco Certificado
                            </div>
                        @endif

                        @if($product->stock < 5)
                            <div class="absolute top-6 left-6 bg-orange-500 text-white px-4 py-2 rounded-full font-bold shadow-lg">
                                ¡Solo quedan {{ $product->stock }}!
                            </div>
                        @endif
                    </div>

                    <!-- Descripción Expandida -->
                    <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Acerca de este producto</h2>
                        <div class="text-gray-700 text-lg leading-relaxed space-y-4">
                            {!! nl2br(e($product->description)) !!}
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-8 pt-8 border-t border-gray-200">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600 mb-1">{{ $product->stock }}</div>
                                <div class="text-sm text-gray-600">Unidades disponibles</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600 mb-1">{{ number_format($product->averageRating(), 1) }}</div>
                                <div class="text-sm text-gray-600">Calificación</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Buy Box (2 columnas) -->
                <div class="lg:col-span-2">
                    <!-- Tarjeta de Compra Pegajosa -->
                    <div class="sticky top-6 bg-white border border-green-200 rounded-2xl p-8 shadow-lg space-y-6">
                        
                        <!-- Título y Precio -->
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-4 line-clamp-3">
                                {{ $product->name }}
                            </h1>
                            <div class="flex items-baseline gap-2">
                                <span class="text-5xl font-bold text-green-600">
                                    ${{ number_format($product->price, 0) }}
                                </span>
                                <span class="text-lg text-gray-500">por unidad</span>
                            </div>
                        </div>

                        <!-- Vendedor Info -->
                        @if($product->user)
                            <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                <div class="text-sm text-gray-600 mb-2">Cultivado por</div>
                                <div class="font-bold text-gray-900 text-lg">
                                    {{ $product->user->name }}
                                </div>
                                <div class="text-xs text-green-700 mt-2">🌱 Agricultor local verificado</div>
                            </div>
                        @endif

                        <!-- Categoría -->
                        <div class="flex items-center gap-3 text-sm">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full font-medium">
                                {{ $product->category->name ?? 'Otros' }}
                            </span>
                            <span class="text-green-600 font-semibold">📦 Envío mañana</span>
                        </div>

                        <hr class="border-gray-200">

                        <!-- Cantidad y Acciones -->
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cantidad</label>
                                    <select name="quantity" class="w-full bg-gray-100 border-none rounded-lg py-3 px-4 font-semibold text-gray-900 focus:ring-2 focus:ring-green-500 cursor-pointer">
                                        @for ($i = 1; $i <= min($product->stock, 10); $i++)
                                            <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'unidad' : 'unidades' }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg text-lg transition-colors shadow-md">
                                    🛒 Agregar al carrito
                                </button>
                            </form>

                            <form action="{{ route('compare.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2 rounded-lg transition-colors">
                                    ⚖️ Comparar
                                </button>
                            </form>
                        @else
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                                <p class="text-red-700 font-semibold">❌ Sin stock</p>
                                <p class="text-red-600 text-sm mt-1">Este producto no está disponible en este momento</p>
                            </div>
                        @endif

                        <!-- Beneficios -->
                        <div class="space-y-3 pt-4 border-t border-gray-200">
                            <div class="flex items-start gap-3 text-sm">
                                <span class="text-lg">✓</span>
                                <div>
                                    <div class="font-semibold text-gray-900">100% Natural</div>
                                    <div class="text-gray-600">Sin químicos sintéticos</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 text-sm">
                                <span class="text-lg">✓</span>
                                <div>
                                    <div class="font-semibold text-gray-900">Comercio Justo</div>
                                    <div class="text-gray-600">Apoyo a agricultores locales</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 text-sm">
                                <span class="text-lg">✓</span>
                                <div>
                                    <div class="font-semibold text-gray-900">Entrega Rápida</div>
                                    <div class="text-gray-600">Llega fresco mañana</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Reseñas -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl p-8 shadow-sm">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Opiniones de la comunidad</h2>

                @if($product->reviews->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <!-- Rating Summary -->
                        <div class="flex items-center gap-8">
                            <div>
                                <div class="text-6xl font-bold text-green-600">
                                    {{ number_format($product->averageRating(), 1) }}
                                </div>
                                <div class="flex text-yellow-400 text-xl mt-2">
                                    @for($i=1; $i<=5; $i++)
                                        {{ $i <= round($product->averageRating()) ? '★' : '☆' }}
                                    @endfor
                                </div>
                                <p class="text-gray-600 mt-2">{{ $product->reviews->count() }} reseñas</p>
                            </div>
                        </div>

                        <!-- Reviews List -->
                        <div class="space-y-4 max-h-96 overflow-y-auto">
                            @foreach($product->reviews()->latest()->take(5)->get() as $review)
                                <div class="border-b border-gray-200 pb-4 last:border-b-0">
                                    <div class="flex text-yellow-400 text-sm mb-2">
                                        @for($i=1; $i<=5; $i++)
                                            {{ $i <= $review->rating ? '★' : '☆' }}
                                        @endfor
                                    </div>
                                    <p class="text-gray-800 font-medium">{{ $review->comment }}</p>
                                    <p class="text-xs text-gray-500 mt-2">
                                        {{ $review->user->name }} • {{ $review->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <span class="text-5xl mb-4 block">🌱</span>
                        <p class="text-gray-600">Este producto aún no tiene reseñas. ¡Sé el primero en opinar!</p>
                    </div>
                @endif

                <!-- Formulario de Reseña -->
                @auth
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Comparte tu experiencia</h3>
                        <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="space-y-4">
                            @csrf
                            @error('review')
                                <div class="bg-red-50 text-red-700 p-4 rounded-lg text-sm">{{ $message }}</div>
                            @enderror

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">¿Qué te pareció?</label>
                                <select name="rating" class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <option value="5">⭐⭐⭐⭐⭐ Excelente</option>
                                    <option value="4">⭐⭐⭐⭐ Muy bueno</option>
                                    <option value="3">⭐⭐⭐ Bueno</option>
                                    <option value="2">⭐⭐ Regular</option>
                                    <option value="1">⭐ Malo</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Comentario (opcional)</label>
                                <textarea name="comment" rows="4" class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="¿Qué te pareció la calidad? ¿Llegó fresco?"></textarea>
                            </div>

                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                                Publicar reseña
                            </button>
                        </form>
                    </div>
                @else
                    <div class="mt-8 pt-8 border-t border-gray-200 bg-gray-50 p-6 rounded-lg text-center">
                        <p class="text-gray-700 mb-3">Inicia sesión para compartir tu opinión y ayudar a otros compradores</p>
                        <a href="{{ route('login') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                            Iniciar sesión
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>

