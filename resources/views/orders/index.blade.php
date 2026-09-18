<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-800 leading-tight">
            {{ __('Mis Pedidos Sostenibles') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                    <div class="flex gap-3">
                        <span class="text-2xl">✓</span>
                        <div>
                            <p class="text-green-700 font-semibold">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            @if($orders->count() > 0)
                <div class="space-y-4">
                    @foreach ($orders as $order)
                        <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden transition hover:shadow-lg">
                            <!-- Order Header -->
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 border-b border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <span class="text-gray-600 font-semibold block text-xs uppercase tracking-wide">Pedido</span>
                                        <span class="text-green-700 font-bold text-xl block">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600 font-semibold block text-xs uppercase tracking-wide">Fecha</span>
                                        <span class="text-gray-900 font-medium">{{ $order->created_at->format('d M Y') }}</span>
                                        <span class="text-gray-500 text-sm">{{ $order->created_at->format('H:i') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600 font-semibold block text-xs uppercase tracking-wide">Total</span>
                                        <span class="text-green-700 font-bold text-xl">${{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600 font-semibold block text-xs uppercase tracking-wide">Estado de Pago</span>
                                        @if($order->status === 'paid')
                                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-200 text-green-800 rounded-full font-semibold text-xs mt-1">
                                                <span class="text-lg">✓</span> Pagado
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-yellow-200 text-yellow-800 rounded-full font-semibold text-xs mt-1">
                                                <span class="text-lg">⏳</span> Pendiente
                                            </span>
                                        @endif
                                        <span class="block text-xs text-gray-500 uppercase tracking-widest font-bold mt-1">
                                            Vía: {{ ucfirst($order->payment_method) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            @php
                                $trackingSteps = [
                                    'paid' => 'Pago confirmado',
                                    'shipped' => 'En camino',
                                    'delivered' => 'Entregado',
                                ];
                                $trackingStatuses = array_keys($trackingSteps);
                                $currentStep = array_search($order->status, $trackingStatuses, true);
                            @endphp
                            <div class="border-b border-gray-100 px-6 py-5">
                                @if($order->status === 'cancelled')
                                    <div class="flex items-center gap-3 rounded-lg bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                                        <span aria-hidden="true">!</span>
                                        Este pedido fue cancelado.
                                    </div>
                                @else
                                    <ol class="grid grid-cols-3 gap-2" aria-label="Seguimiento del pedido">
                                        @foreach($trackingSteps as $status => $label)
                                            @php $isComplete = $currentStep !== false && $loop->index <= $currentStep; @endphp
                                            <li class="text-center text-xs font-semibold {{ $isComplete ? 'text-green-700' : 'text-gray-400' }}">
                                                <div class="mx-auto mb-2 flex h-8 w-8 items-center justify-center rounded-full {{ $isComplete ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-400' }}">
                                                    {{ $isComplete ? '✓' : $loop->iteration }}
                                                </div>
                                                {{ $label }}
                                            </li>
                                        @endforeach
                                    </ol>
                                @endif
                            </div>
                            
                            <!-- Order Items -->
                            <div class="p-6">
                                <h4 class="font-bold text-gray-900 mb-4">Artículos del Pedido</h4>
                                <ul class="divide-y divide-gray-100">
                                    @foreach($order->items as $item)
                                        <li class="py-4 flex gap-4">
                                            <div class="flex-shrink-0">
                                                @if($item->product->image ?? null)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="img" class="w-16 h-16 rounded-lg object-cover shadow-sm">
                                                @else
                                                    <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center text-2xl">🌱</div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <a href="{{ route('products.show', $item->product->id) }}" class="font-semibold text-gray-900 hover:text-green-600 block truncate">
                                                    {{ $item->product->name ?? 'Producto Eliminado' }}
                                                </a>
                                                <span class="text-sm text-gray-600">
                                                    {{ $item->quantity }} ud. × ${{ number_format($item->price, 2) }}
                                                </span>
                                            </div>
                                            <div class="text-right flex-shrink-0">
                                                <div class="font-bold text-gray-900">
                                                    ${{ number_format($item->price * $item->quantity, 2) }}
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl border-2 border-dashed border-gray-300 p-12 text-center">
                    <div class="text-6xl mb-4">🛍️</div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Aún no has realizado compras</h2>
                    <p class="text-gray-600 mb-6">
                        Explora nuestro catálogo de productos sostenibles y apoya a los comerciantes locales
                    </p>
                    <a href="{{ route('products.index') }}" class="inline-block bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 px-8 rounded-lg transition transform hover:scale-105">
                        🌿 Explorar Catálogo
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
