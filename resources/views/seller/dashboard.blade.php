<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-800 leading-tight">
            📊 Panel Analítico de Tu Granja
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- KPIs -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Ventas Totales -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Ingresos Totales</p>
                        <h3 class="text-3xl font-extrabold text-green-700 mt-2">${{ number_format($totalSales, 2) }}</h3>
                        <span class="text-xs text-gray-400 mt-1 block">Generado en total (histórico)</span>
                    </div>
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center text-3xl">
                        💰
                    </div>
                </div>

                <!-- Productos Activos -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Cultivos Activos</p>
                        <h3 class="text-3xl font-extrabold text-gray-800 mt-2">{{ number_format($activeProducts) }} <span class="text-lg text-gray-500 font-normal">productos</span></h3>
                        <a href="{{ route('seller.productos.index') }}" class="text-xs text-blue-600 hover:underline mt-1 block">Gestionar mi mercancía &rarr;</a>
                    </div>
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-3xl">
                        🌾
                    </div>
                </div>
                
                <!-- Envíos Pendientes (Visualización simplificada) -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Top Venta</p>
                        <h3 class="text-xl font-extrabold text-gray-800 mt-2 overflow-hidden text-ellipsis whitespace-nowrap max-w-[150px]">
                            {{ $topProducts->first()->product->name ?? 'Ninguno' }}
                        </h3>
                        <span class="text-xs text-gray-400 mt-1 block">Producto más exitoso</span>
                    </div>
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center text-3xl">
                        🌟
                    </div>
                </div>
            </div>

            <!-- Gráfico y Tabla Principal -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Gráfico de Ventas -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Ingresos Últimos 7 Días</h3>
                    <div class="relative h-64">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <!-- Tabla de Productos Estrella -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 h-full flex flex-col">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Tus Mejores Cosechas (Top 5)</h3>
                    @if($topProducts->count() > 0)
                        <div class="flex-1 overflow-y-auto pr-2">
                            <ul class="divide-y divide-gray-100">
                                @foreach($topProducts as $item)
                                    <li class="py-3 flex justify-between items-center group hover:bg-gray-50 rounded-lg px-2 transition-colors -mx-2">
                                        <div class="flex items-center gap-3">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-12 h-12 rounded object-cover border border-gray-200">
                                            @else
                                                <div class="w-12 h-12 rounded bg-green-50 text-green-300 flex items-center justify-center text-xl">🌱</div>
                                            @endif
                                            <div>
                                                <p class="font-bold text-gray-800 line-clamp-1">{{ $item->product->name }}</p>
                                                <p class="text-xs text-gray-500 font-semibold mt-0.5">{{ $item->total_quantity }} uds. vendidas</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-extrabold text-green-700">${{ number_format($item->total_revenue, 2) }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="flex-1 flex flex-col justify-center items-center text-center">
                            <span class="text-5xl mb-2">📉</span>
                            <p class="text-gray-500 text-sm">Aún no hay datos suficientes de ventas para mostrar aquí. ¡Sigue publicando tus cosechas!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Últimos Pedidos Recibidos (Integración Logística - WhatsApp) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Últimos Pedidos Encomendados a tu Granja</h3>
                
                @if($recentOrders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Fecha / Pedido</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Cliente (Contacto)</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Producto y Cant.</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Tus Ganancias</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentOrders as $recent)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="font-bold text-gray-800">{{ $recent->created_at->format('d M, Y') }}</div>
                                            <div class="text-xs uppercase tracking-wide">ID: #{{ $recent->order_id }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-bold text-gray-900">{{ $recent->order->user->name }}</div>
                                            @if($recent->order->user->phone)
                                                <!-- Botón de WhatsApp dinámico -->
                                                @php
                                                    // Sanear el número
                                                    $phone = preg_replace('/[^0-9]/', '', $recent->order->user->phone);
                                                    $mensaje = urlencode("Hola {$recent->order->user->name}, soy el agricultor de Ecoventa y te escribo para coordinar la entrega de tu pedido #{$recent->order_id} ({$recent->product->name}).");
                                                @endphp
                                                <a href="https://wa.me/{{ $phone }}?text={{ $mensaje }}" target="_blank" class="mt-1 inline-flex items-center text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full border border-green-200 hover:bg-green-100 hover:text-green-800 transition">
                                                    <span class="mr-1">💬</span> WhatsApp ({{ $recent->order->user->phone }})
                                                </a>
                                            @else
                                                <div class="text-xs text-gray-400 mt-1">Sin teléfono (Contactar vía Email)</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <span class="bg-gray-100 text-gray-800 font-black text-xs px-2 py-1 rounded">{{ $recent->quantity }}x</span>
                                                <span class="text-sm font-semibold text-gray-700">{{ $recent->product->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-extrabold text-green-700">
                                            ${{ number_format($recent->price * $recent->quantity, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-6">
                        <span class="text-gray-400 block mb-2">No has recibido pedidos recientes.</span>
                    </div>
                @endif
            </div>

        </div>
    </div>


    <!-- Inyección de Chart.js mediante CDN de manera segura y controlada -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart');
            
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($chartDates) !!}, // Días 
                        datasets: [{
                            label: 'Ingresos diarios ($)',
                            data: {!! json_encode($chartTotals) !!}, // Totales ganados
                            borderColor: '#15803d', // green-700
                            backgroundColor: 'rgba(34, 197, 94, 0.1)', // green-500 suave
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4, // Curva suave
                            pointBackgroundColor: '#15803d',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: '#15803d',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(17, 24, 39, 0.9)',
                                titleFont: { size: 13 },
                                bodyFont: { size: 14, weight: 'bold' },
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                border: { display: false },
                                grid: {
                                    color: '#f3f4f6', // gray-100
                                },
                                ticks: {
                                    font: { size: 11, family: 'system-ui' },
                                    color: '#9ca3af',
                                    callback: function(value) {
                                        return '$' + value;
                                    }
                                }
                            },
                            x: {
                                border: { display: false },
                                grid: { display: false },
                                ticks: {
                                    font: { size: 11, family: 'system-ui' },
                                    color: '#9ca3af'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush

</x-app-layout>
