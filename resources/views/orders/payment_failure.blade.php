<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-800 leading-tight">
            ✗ Pago Fallido
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-red-50 to-white min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-2xl border border-red-200 shadow-lg p-12 text-center">
                <div class="text-6xl mb-6">❌</div>
                
                <h1 class="text-4xl font-bold text-red-700 mb-3">Pago No Procesado</h1>
                <p class="text-gray-600 text-lg mb-8">
                    Hubo un problema al procesar tu pago. Por favor intenta de nuevo.
                </p>

                <div class="bg-red-50 rounded-xl p-6 mb-8 border border-red-200 text-left">
                    <h3 class="font-bold text-red-900 mb-3">Posibles razones:</h3>
                    <ul class="space-y-2 text-red-800 text-sm">
                        <li>• Fondos insuficientes en tu tarjeta</li>
                        <li>• Datos de tarjeta incorrectos</li>
                        <li>• Tu banco rechazó la transacción</li>
                        <li>• Conexión de internet interrumpida</li>
                    </ul>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('checkout') }}" class="inline-block w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-6 rounded-lg transition">
                        Intentar de Nuevo
                    </a>
                    <a href="{{ route('cart.index') }}" class="inline-block w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition">
                        Volver al Carrito
                    </a>
                </div>

                <p class="text-gray-500 text-sm mt-8">
                    Si el problema persiste, contáctanos: support@ecoventa.com
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
