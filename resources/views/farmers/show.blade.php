<x-app-layout>
    <x-slot name="header">
        <div><p class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-800">Comunidad local</p><h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">Perfil del agricultor</h2></div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            <section class="rounded-2xl border border-emerald-100 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
                    @if($user->avatar)<img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="h-24 w-24 rounded-full object-cover ring-4 ring-emerald-50">@else<div class="flex h-24 w-24 items-center justify-center rounded-full bg-emerald-100 text-3xl font-bold text-emerald-800">{{ strtoupper(substr($user->name, 0, 1)) }}</div>@endif
                    <div><p class="text-sm font-semibold text-emerald-800">Agricultor local</p><h1 class="mt-1 text-3xl font-bold text-slate-900">{{ $user->name }}</h1><p class="mt-3 max-w-2xl text-slate-600">{{ $user->bio ?: 'Productor local comprometido con alimentos frescos y prácticas responsables.' }}</p></div>
                </div>
                <div class="mt-6 flex flex-wrap gap-3 text-sm"><span class="rounded-full bg-emerald-50 px-3 py-1 font-semibold text-emerald-800">Productos activos: {{ $products->total() }}</span><span class="rounded-full bg-slate-100 px-3 py-1 font-semibold text-slate-700">Comercio directo</span></div>
            </section>

            <section><h2 class="text-xl font-bold text-slate-900">Productos de {{ $user->name }}</h2><div class="mt-5 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">@forelse($products as $product)<a href="{{ route('products.show', $product) }}" class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md"><div class="flex h-48 items-center justify-center bg-emerald-50">@if($product->image)<img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">@else<span class="text-5xl">🍃</span>@endif</div><div class="p-5"><p class="text-xs font-bold uppercase tracking-wide text-emerald-800">{{ $product->category?->name ?? 'Producto local' }}</p><h3 class="mt-2 font-bold text-slate-900">{{ $product->name }}</h3><p class="mt-2 text-xl font-bold text-emerald-800">${{ number_format($product->price, 2) }}</p></div></a>@empty<div class="rounded-xl border border-dashed border-emerald-200 bg-white p-8 text-slate-600">Este agricultor todavía no tiene productos activos.</div>@endforelse</div><div class="mt-8">{{ $products->links() }}</div></section>
        </div>
    </div>
</x-app-layout>
