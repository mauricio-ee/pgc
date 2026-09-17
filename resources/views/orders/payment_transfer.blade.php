<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-800 leading-tight">
            Transferencia Bancaria
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-blue-50 to-white min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-2xl border border-blue-200 shadow-lg p-12">
                <div class="text-center mb-8">
                    <div class="text-6xl mb-4">🏦</div>
                    <h1 class="text-3xl font-bold text-blue-700">Realiza tu Transferencia</h1>
                    <p class="text-gray-600 mt-2">
                        Tu pedido está listo. Transfiere el monto indicado para confirmarlo.
                    </p>
                </div>

                <!-- Datos del Pedido -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8">
                    <h3 class="font-bold text-gray-900 mb-4">Detalles del Pedido</h3>
                    <div class="space-y-2 text-gray-700">
                        <div class="flex justify-between">
                            <span>Número de Pedido:</span>
                            <span class="font-semibold">#{{ $order->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Total a Pagar:</span>
                            <span class="font-bold text-2xl text-green-600">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                @php
                    $bankData = $payment->metadata;
                @endphp

                <!-- Datos Bancarios -->
                <div class="bg-blue-50 rounded-xl p-6 mb-8 border-l-4 border-blue-500">
                    <h3 class="font-bold text-blue-900 mb-4">Datos para la Transferencia:</h3>
                    
                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-lg">
                            <p class="text-gray-600 text-sm mb-1">Banco:</p>
                            <p class="text-gray-900 font-semibold text-lg">{{ $bankData['bank_name'] ?? 'Banco Agrario' }}</p>
                        </div>

                        <div class="bg-white p-4 rounded-lg">
                            <p class="text-gray-600 text-sm mb-1">Número de Cuenta:</p>
                            <div class="flex items-center justify-between">
                                <p class="text-gray-900 font-mono font-bold text-lg">{{ $bankData['account'] ?? '1234567890' }}</p>
                                <button onclick="navigator.clipboard.writeText('{{ $bankData['account'] ?? '' }}'); alert('Copiado');" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                    Copiar
                                </button>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-lg">
                            <p class="text-gray-600 text-sm mb-1">Concepto/Referencia:</p>
                            <div class="flex items-center justify-between">
                                <p class="text-gray-900 font-mono font-bold">{{ $bankData['reference'] ?? 'ECO-00001' }}</p>
                                <button onclick="navigator.clipboard.writeText('{{ $bankData['reference'] ?? '' }}'); alert('Copiado');" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                    Copiar
                                </button>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-lg">
                            <p class="text-gray-600 text-sm mb-1">Monto:</p>
                            <p class="text-gray-900 font-bold text-2xl text-green-600">${{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Instrucciones -->
                <div class="bg-yellow-50 rounded-xl p-6 mb-8 border-l-4 border-yellow-500">
                    <h3 class="font-bold text-yellow-900 mb-4">⚠️ Importante:</h3>
                    <ol class="space-y-2 text-yellow-800 text-sm">
                        <li>1. Copia el número de cuenta exactamente</li>
                        <li>2. En el concepto, usa la referencia del pedido (ECO-XXXXX)</li>
                        <li>3. Realiza la transferencia desde tu banco</li>
                        <li>4. Guarda el comprobante</li>
                        <li>5. Espera confirmación (hasta 24 horas)</li>
                    </ol>
                </div>

                <!-- Acciones -->
                <div class="space-y-3">
                    <a href="{{ route('orders.index') }}" class="inline-block w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg text-center transition">
                        Ver mis pedidos
                    </a>
                    <a href="{{ route('products.index') }}" class="inline-block w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg text-center transition">
                        Seguir comprando
                    </a>
                </div>

                <div class="bg-green-50 rounded-xl p-6 mt-8 text-center border border-green-200">
                    <p class="text-green-900 text-sm">
                        <strong>¿Necesitas ayuda?</strong><br>
                        Contáctanos: support@ecoventa.com o +57 300 123 4567
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
