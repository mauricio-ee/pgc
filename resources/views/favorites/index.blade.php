<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-800">Tu selección</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">Favoritos</h2>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 p-4 font-medium text-emerald-800">{{ session('success') }}</div>
            @endif

            @if($favorites->count())
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($favorites as $favorite)
                        @php($product = $favorite->product)
                        <article class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                            <a href="{{ route('products.show', $product) }}" class="block">
                                <div class="flex h-48 items-center justify-center bg-emerald-50">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="text-5xl" aria-hidden="true">🍃</span>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <p class="text-xs font-bold uppercase tracking-wide text-emerald-800">{{ $product->category?->name ?? 'Producto local' }}</p>
                                    <h3 class="mt-2 text-lg font-bold text-slate-900">{{ $product->name }}</h3>
                                    <p class="mt-2 text-2xl font-bold text-emerald-800">${{ number_format($product->price, 2) }}</p>
                                </div>
                            </a>
                            <form action="{{ route('favorites.destroy', $product) }}" method="POST" class="border-t border-slate-100 p-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-red-200 hover:bg-red-50 hover:text-red-700">Quitar de favoritos</button>
                            </form>
                        </article>
                    @endforeach
                </div>
                <div class="mt-8">{{ $favorites->links() }}</div>
            @else
                <div class="rounded-xl border border-dashed border-emerald-200 bg-white px-6 py-20 text-center">
                    <div class="text-5xl" aria-hidden="true">♡</div>
                    <h3 class="mt-4 text-xl font-bold text-slate-900">Aún no tienes favoritos</h3>
                    <p class="mt-2 text-slate-600">Guarda productos para encontrarlos rápidamente después.</p>
                    <a href="{{ route('products.index') }}" class="mt-6 inline-flex rounded-lg bg-emerald-800 px-5 py-3 font-bold text-white hover:bg-emerald-900">Explorar catálogo</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
