<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-800 leading-tight">
            Tu Carrito de Cultivo 🛒
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg" role="alert">
                    <div class="flex gap-2">
                        <span>✓</span>
                        <span class="text-green-700 font-semibold">{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg" role="alert">
                    <div class="flex gap-2">
                        <span>⚠️</span>
                        <span class="text-red-700 font-semibold">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if(count($products) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Lista de Productos -->
                    <div class="lg:col-span-2 space-y-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-2xl font-bold text-gray-900">Productos Seleccionados</h3>
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-800 transition">
                                    🗑️ Vaciar Carrito
                                </button>
                            </form>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach($products as $product)
                                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex flex-col sm:flex-row gap-6">
                                        
                                        <!-- Imagen -->
                                        <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center border border-gray-200">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-2xl">🍃</span>
                                            @endif
                                        </div>
                                        
                                        <!-- Info y Título -->
                                        <div class="flex-grow">
                                            <a href="{{ route('products.show', $product->id) }}" class="text-lg font-bold text-gray-900 hover:text-green-600 transition">
                                                {{ $product->name }}
                                            </a>
                                            
                                            @if(!$product->user)
                                                <div class="mt-2 bg-red-50 border-l-4 border-red-500 p-3 rounded-md">
                                                    <p class="text-sm text-red-700 font-semibold">⚠️ Vendedor no disponible</p>
                                                    <p class="text-xs text-red-600 mt-1">El agricultor ha eliminado su cuenta. Este producto no se puede comprar.</p>
                                                </div>
                                            @elseif(auth()->check() && $product->user_id === auth()->id())
                                                <div class="mt-2 bg-yellow-50 border-l-4 border-yellow-500 p-3 rounded-md">
                                                    <p class="text-sm text-yellow-700 font-semibold">⚠️ Producto propio</p>
                                                    <p class="text-xs text-yellow-600 mt-1">No puedes comprar tus propios productos.</p>
                                                </div>
                                            @else
                                                <div class="text-sm text-gray-500 font-medium mt-1">Vendido por: <strong class="text-gray-700">{{ $product->user->name }}</strong></div>
                                            @endif
                                            
                                            <div class="mt-2 text-lg font-bold text-green-600">${{ number_format($product->price, 2) }} c/u</div>
                                        </div>

                                        <!-- Acciones de Cantidad -->
                                        <div class="flex flex-col items-end gap-3 flex-shrink-0">
                                            <form action="{{ route('cart.update', $product->id) }}" method="POST" class="flex items-center gap-2 bg-gray-50 rounded-lg p-2">
                                                @csrf
                                                <input type="number" name="quantity" value="{{ $cart[$product->id]['quantity'] }}" min="1" max="{{ $product->stock }}" class="w-16 text-center rounded-md border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm">
                                                <button type="submit" class="text-sm bg-green-600 hover:bg-green-700 text-white font-semibold px-3 py-2 rounded-md transition">
                                                    ↻
                                                </button>
                                            </form>

                                            <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-xs font-semibold text-red-500 hover:text-red-700 underline transition">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Resumen del Pedido (Checkout) -->
                    <div>
                        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sticky top-6">
                            <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-4 mb-4">📋 Resumen</h3>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-gray-600 text-sm">
                                    <span>Subtotal ({{ count($cart) }} productos)</span>
                                    <span>${{ number_format($total, 2) }}</span>
                                </div>
                                
                                <div class="flex justify-between text-gray-600 text-sm">
                                    <span>Envío Ecológico</span>
                                    <span class="text-green-600 font-semibold">Gratis</span>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-4 mb-6">
                                <div class="flex justify-between text-2xl font-extrabold text-green-600">
                                    <span>Total</span>
                                    <span>${{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            @php
                                $hasOrphanedProducts = $products->contains(function ($p) {
                                    return is_null($p->user);
                                });
                                $hasOwnProducts = auth()->check() && $products->contains(function ($p) {
                                    return $p->user_id === auth()->id();
                                });
                            @endphp

                            @auth
                                @if($hasOrphanedProducts)
                                    <div class="bg-red-50 text-red-700 p-4 rounded-lg text-sm text-center font-semibold mb-4">
                                        ⚠️ Debes eliminar productos de vendedores inactivos
                                    </div>
                                    <button disabled class="w-full bg-gray-400 text-gray-600 font-bold text-lg py-4 rounded-lg shadow-md cursor-not-allowed opacity-50">
                                        ✓ Proceder al Pago
                                    </button>
                                @elseif($hasOwnProducts)
                                    <div class="bg-yellow-50 text-yellow-800 p-4 rounded-lg text-sm text-center font-semibold mb-4">
                                        ⚠️ Quita tus propios productos del carrito
                                    </div>
                                    <button disabled class="w-full bg-gray-400 text-gray-600 font-bold text-lg py-4 rounded-lg shadow-md cursor-not-allowed opacity-50">
                                        ✓ Proceder al Pago
                                    </button>
                                @else
                                    <a href="{{ route('checkout') }}" class="block text-center w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold text-lg py-4 rounded-lg shadow-lg transition transform hover:scale-[1.02] active:scale-95">
                                        ✓ Proceder al Pago
                                    </a>
                                @endif
                                <p class="text-xs text-gray-500 text-center mt-4">
                                    🔒 Pago seguro con nuestras pasarelas integradas
                                </p>
                            @else
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4 rounded-r-lg">
                                    <p class="text-sm text-blue-700">
                                        Debes <strong>iniciar sesión</strong> o <strong>registrarte</strong> para finalizar la compra
                                    </p>
                                </div>
                                <a href="{{ route('login') }}" class="block text-center w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-4 rounded-lg shadow-lg transition transform hover:scale-[1.02]">
                                    Iniciar Sesión
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl border-2 border-dashed border-gray-300 p-12 text-center">
                    <div class="text-6xl mb-4">🍃</div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">Tu carrito está vacío</h2>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        Todavía no has agregado productos. Apoya a los productores locales sostenibles.
                    </p>
                    <a href="{{ route('products.index') }}" class="inline-block bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold px-8 py-3 rounded-lg shadow-lg transition transform hover:scale-105">
                        🌿 Explorar Catálogo
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
