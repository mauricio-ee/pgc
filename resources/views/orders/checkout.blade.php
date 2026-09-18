<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-800 leading-tight">
            Finalizar Compra 🛒
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0 text-2xl">⚠️</div>
                        <div class="ml-3">
                            <p class="text-red-700 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Progress Steps -->
            <div class="mb-8 grid grid-cols-3 gap-4">
                <div class="flex items-center justify-center bg-green-100 text-green-700 rounded-full h-12 font-bold border-2 border-green-500">
                    ✓
                </div>
                <div class="flex items-center justify-center bg-green-100 text-green-700 rounded-full h-12 font-bold border-2 border-green-500">
                    ✓
                </div>
                <div class="flex items-center justify-center bg-green-500 text-white rounded-full h-12 font-bold border-2 border-green-500">
                    3
                </div>
            </div>

            <form action="{{ route('payment.initiate') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Formulario de Dirección y Pago -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- 1. Dirección -->
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-green-100">
                                    <span class="text-green-600 font-bold">1</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Dirección de Envío</h3>
                            </div>
                            
                            <div>
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">Dirección Completa</label>
                                <textarea name="shipping_address" id="shipping_address" rows="3" required placeholder="Ej. Calle 123 #45-67, Ciudad, Barrio" class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- 2. Método de Pago -->
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-green-100">
                                    <span class="text-green-600 font-bold">2</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Método de Pago</h3>
                            </div>
                            
                            <div class="space-y-3">
                                <label class="flex items-center justify-between p-4 border-2 rounded-lg cursor-pointer hover:bg-green-50 border-green-500 bg-green-50 transition">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="mercado_pago" class="text-green-600 focus:ring-green-500 h-4 w-4" checked>
                                        <span class="font-medium text-gray-900">Mercado Pago</span>
                                    </div>
                                    <span class="text-xl">💳</span>
                                </label>

                                <label class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="transfer" class="text-green-600 focus:ring-green-500 h-4 w-4">
                                        <span class="font-medium text-gray-900">Transferencia Bancaria</span>
                                    </div>
                                    <span class="text-xl">🏦</span>
                                </label>
                            </div>
                            @error('payment_method')
                                <p class="text-red-500 text-xs mt-3">{{ $message }}</p>
                            @enderror
                            
                            <div class="mt-4 p-4 bg-blue-50 rounded-lg text-sm text-blue-700 flex gap-2">
                                <span class="flex-shrink-0">ℹ️</span>
                                <span><strong>Mercado Pago:</strong> Serás redirigido a la plataforma segura. <strong>Transferencia:</strong> Recibirás los datos bancarios después de confirmar.</span>
                            </div>
                        </div>

                    </div>

                    <!-- Resumen a la derecha -->
                    <div>
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sticky top-6">
                            <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-4 mb-4">📋 Resumen</h3>
                            
                            <div class="space-y-3 mb-4 max-h-64 overflow-y-auto pr-2">
                                @foreach($products as $product)
                                    <div class="flex justify-between items-start gap-2 text-sm">
                                        <div>
                                            <span class="text-gray-600 block">{{ $cart[$product->id]['quantity'] }}x</span>
                                            <span class="text-gray-700 font-medium truncate block">{{ $product->name }}</span>
                                        </div>
                                        <span class="font-bold text-gray-900 flex-shrink-0">${{ number_format($product->price * $cart[$product->id]['quantity'], 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4 mb-6 space-y-2">
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Subtotal:</span>
                                    <span>${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Envío:</span>
                                    <span class="font-semibold text-green-600">Gratis</span>
                                </div>
                                <div class="flex justify-between text-2xl font-extrabold text-green-600">
                                    <span>Total:</span>
                                    <span>${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                            
                            <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold text-lg py-4 rounded-lg shadow-lg transition transform hover:scale-[1.02] active:scale-95">
                                ✓ Confirmar Compra
                            </button>
                            <a href="{{ route('cart.index') }}" class="block text-center mt-3 text-sm text-gray-500 hover:text-gray-700 transition">
                                ← Volver al Carrito
                            </a>
                        </div>
                    </div>
                    
                </div>
            </form>

        </div>
    </div>

</x-app-layout>
