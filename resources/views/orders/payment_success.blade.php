<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-800 leading-tight">
            ✓ Pago Exitoso
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-green-50 to-white min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-2xl border border-green-200 shadow-lg p-12 text-center">
                <div class="text-6xl mb-6">🎉</div>
                
                <h1 class="text-4xl font-bold text-green-700 mb-3">¡Pago Realizado!</h1>
                <p class="text-gray-600 text-lg mb-8">
                    Tu pedido ha sido procesado correctamente.
                </p>

                <div class="bg-green-50 rounded-xl p-6 mb-8 border border-green-200">
                    <p class="text-gray-700 mb-2">
                        <span class="font-semibold">Número de Pedido:</span> #{{ $order->id }}
                    </p>
                    <p class="text-gray-700 mb-2">
                        <span class="font-semibold">Monto Total:</span> ${{ number_format($order->total_amount, 2) }}
                    </p>
                    <p class="text-gray-700">
                        <span class="font-semibold">Estado:</span> <span class="text-green-600 font-bold">Pagado</span>
                    </p>
                </div>

                <div class="bg-blue-50 rounded-xl p-6 mb-8 border border-blue-200 text-left">
                    <h3 class="font-bold text-blue-900 mb-3">Próximos Pasos:</h3>
                    <ul class="space-y-2 text-blue-800">
                        <li>✓ Verificaremos tu pedido</li>
                        <li>✓ Prepararemos tu envío</li>
                        <li>✓ Recibirás tu compra en 1-3 días hábiles</li>
                        <li>✓ Te enviaremos confirmación por email</li>
                    </ul>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('orders.index') }}" class="inline-block w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition">
                        Ver mis pedidos
                    </a>
                    <a href="{{ route('products.index') }}" class="inline-block w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition">
                        Seguir comprando
                    </a>
                </div>

                <p class="text-gray-500 text-sm mt-8">
                    Gracias por apoyar el comercio sostenible 🌿
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
