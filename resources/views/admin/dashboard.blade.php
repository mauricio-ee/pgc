<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-800">Administración</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">Resumen de Ecoventa</h2>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach([
                    ['Usuarios', $stats['users'], 'text-slate-900'],
                    ['Vendedores', $stats['sellers'], 'text-emerald-800'],
                    ['Productos activos', $stats['products'], 'text-emerald-800'],
                    ['Pedidos', $stats['orders'], 'text-slate-900'],
                ] as [$label, $value, $color])
                    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-500">{{ $label }}</p>
                        <p class="mt-2 text-3xl font-extrabold {{ $color }}">{{ number_format($value) }}</p>
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-500">Rendimiento</p>
                            <h3 class="mt-1 text-xl font-bold text-slate-900">Ventas y pedidos</h3>
                        </div>
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-bold text-emerald-800">${{ number_format($stats['revenue'], 2) }}</span>
                    </div>
                    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-4">
                        <div class="rounded-lg bg-emerald-50 p-4"><p class="text-xs text-emerald-700">Pagados</p><p class="mt-1 text-2xl font-bold text-emerald-900">{{ $stats['paidOrders'] }}</p></div>
                        <div class="rounded-lg bg-amber-50 p-4"><p class="text-xs text-amber-700">Pendientes</p><p class="mt-1 text-2xl font-bold text-amber-900">{{ $stats['pendingOrders'] }}</p></div>
                    </div>
                    <a href="{{ route('admin.orders.all') }}" class="mt-6 inline-flex font-semibold text-emerald-800 hover:text-emerald-950">Gestionar pedidos &rarr;</a>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-500">Catálogo</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Categorías activas</h3>
                    <ul class="mt-5 divide-y divide-slate-100">
                        @forelse($topCategories as $category)
                            <li class="flex justify-between py-3 text-sm"><span class="text-slate-700">{{ $category->name }}</span><strong class="text-emerald-800">{{ $category->products_count }}</strong></li>
                        @empty
                            <li class="py-3 text-sm text-slate-500">Aún no hay productos.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between"><h3 class="text-xl font-bold text-slate-900">Pedidos recientes</h3><a href="{{ route('admin.orders.all') }}" class="text-sm font-semibold text-emerald-800">Ver todos</a></div>
                <div class="mt-5 overflow-x-auto"><table class="min-w-full divide-y divide-slate-200 text-sm"><thead><tr class="text-left text-xs uppercase tracking-wide text-slate-500"><th class="px-3 py-3">Pedido</th><th class="px-3 py-3">Cliente</th><th class="px-3 py-3">Total</th><th class="px-3 py-3">Estado</th></tr></thead><tbody class="divide-y divide-slate-100">@forelse($recentOrders as $order)<tr><td class="px-3 py-3 font-semibold">#{{ $order->id }}</td><td class="px-3 py-3">{{ $order->user?->name ?? 'Usuario eliminado' }}</td><td class="px-3 py-3">${{ number_format($order->total_amount, 2) }}</td><td class="px-3 py-3"><span class="rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">{{ ucfirst($order->status) }}</span></td></tr>@empty<tr><td colspan="4" class="px-3 py-6 text-center text-slate-500">No hay pedidos registrados.</td></tr>@endforelse</tbody></table></div>
            </div>
        </div>
    </div>
</x-app-layout>
