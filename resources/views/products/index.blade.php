<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-800">Ecoventa</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">Productos de temporada</h2>
            </div>
            <span class="hidden rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 sm:inline-flex">Comercio local</span>
        </div>
    </x-slot>

    <!-- Hero Section con Búsqueda -->
    <div class="border-b border-emerald-100 bg-emerald-50 py-10 text-emerald-950">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-6">
                <p class="text-sm font-medium tracking-wide text-emerald-800">Descubre productos naturales de agricultores locales</p>
            </div>
            <div class="flex flex-col md:flex-row gap-3">
                <form action="{{ route('products.index') }}" method="GET" class="grid flex-1 grid-cols-1 gap-3 sm:grid-cols-[minmax(0,1fr)_auto]">
                    <input type="text" name="search" placeholder="Buscar por nombre..." value="{{ request('search') }}" class="flex-1 rounded-lg border border-emerald-200 bg-white px-4 py-3 text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <div class="grid grid-cols-2 gap-3 sm:col-span-2 md:grid-cols-4">
                        <input type="number" name="min_price" min="0" step="0.01" value="{{ request('min_price') }}" placeholder="Precio mínimo" class="rounded-lg border border-emerald-200 bg-white px-4 py-3 text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <input type="number" name="max_price" min="0" step="0.01" value="{{ request('max_price') }}" placeholder="Precio máximo" class="rounded-lg border border-emerald-200 bg-white px-4 py-3 text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <select name="sort" class="rounded-lg border border-emerald-200 bg-white px-4 py-3 text-slate-800 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="latest" @selected(request('sort', 'latest') === 'latest')>Más recientes</option>
                            <option value="price_asc" @selected(request('sort') === 'price_asc')>Precio menor</option>
                            <option value="price_desc" @selected(request('sort') === 'price_desc')>Precio mayor</option>
                            <option value="name" @selected(request('sort') === 'name')>Nombre A-Z</option>
                        </select>
                        <button type="submit" class="rounded-lg bg-emerald-800 px-6 py-3 font-semibold text-white shadow-sm transition hover:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                            Buscar productos
                        </button>
                    </div>
                </form>
            </div>
            <div class="mt-4 flex flex-wrap items-center justify-between gap-3 text-sm text-emerald-900">
                <p>{{ $products->total() }} {{ $products->total() === 1 ? 'producto encontrado' : 'productos encontrados' }}</p>
                @if(request()->hasAny(['search', 'min_price', 'max_price', 'sort', 'categoria']))
                    <a href="{{ route('products.index') }}" class="font-semibold underline underline-offset-4 hover:text-emerald-700">Limpiar filtros</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Filtros Horizontales -->
    <div class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="flex items-center gap-3 overflow-x-auto pb-2">
                <span class="whitespace-nowrap text-sm font-semibold text-slate-500">Categorías</span>
                <a href="{{ route('products.index', request()->only(['search', 'min_price', 'max_price', 'sort'])) }}" class="whitespace-nowrap rounded-full px-4 py-2 text-sm font-medium {{ !request('categoria') ? 'bg-emerald-800 text-white' : 'bg-slate-100 text-slate-700 hover:bg-emerald-50 hover:text-emerald-900' }} transition">
                    Todas
                </a>
                @foreach($categories as $cat)
                        <a href="{{ route('products.index', array_merge(request()->only(['search', 'min_price', 'max_price', 'sort']), ['categoria' => $cat->slug])) }}" class="whitespace-nowrap rounded-full px-4 py-2 text-sm font-medium {{ request('categoria') == $cat->slug ? 'bg-emerald-800 text-white' : 'bg-slate-100 text-slate-700 hover:bg-emerald-50 hover:text-emerald-900' }} transition">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Grid Principal - Diseño Masónico -->
    <div class="min-h-screen bg-white py-12 pb-32">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 auto-rows-max">
                    @foreach ($products as $product)
                        <div class="group cursor-pointer">
                            <a href="{{ route('products.show', $product->id) }}" class="block">
                                <!-- Imagen con Overlay -->
                                <div class="relative h-64 overflow-hidden rounded-lg bg-gray-100 mb-3 shadow-md hover:shadow-xl transition-shadow">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-green-100 to-emerald-100">
                                            <span class="text-5xl">🍃</span>
                                        </div>
                                    @endif
                                    
                                    @if($product->is_eco_certified)
                                        <div class="absolute top-3 right-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                            ✓ Eco
                                        </div>
                                    @endif
                                    
                                    <!-- Stock Badge -->
                                    @if($product->stock === 0)
                                        <div class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                                            Sin stock
                                        </div>
                                    @elseif($product->stock < 5)
                                        <div class="absolute top-3 left-3 bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                            ¡Quedan {{$product->stock}}!
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Info Card -->
                                <div class="space-y-2">
                                    <div class="text-xs font-semibold text-green-600 tracking-wider uppercase">
                                        {{ $product->category?->name ?? 'Otros' }} •
                                        @if($product->user)
                                            <a href="{{ route('farmers.show', $product->user) }}" class="hover:text-emerald-900">{{ $product->user->name }}</a>
                                        @else
                                            Agricultor
                                        @endif
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 line-clamp-2 min-h-[2.5rem] group-hover:text-green-700 transition">
                                        {{ $product->name }}
                                    </h3>
                                    <div class="flex justify-between items-end pt-2">
                                        <div>
                                            <div class="text-2xl font-bold text-green-700">
                                                ${{ number_format($product->price, 0) }}
                                            </div>
                                            <div class="text-xs text-gray-500">por unidad</div>
                                        </div>
                                        <div class="text-sm font-semibold text-emerald-800">
                                            📦 Lleva mañana
                                        </div>
                                    </div>
                                </div>
                            </a>
                            
                            <!-- Botones de Acción -->
                            <div class="mt-3 flex gap-2">
                                @auth
                                    <form action="{{ route('favorites.store', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 font-bold text-emerald-800 transition hover:bg-emerald-100" title="Guardar en favoritos" aria-label="Guardar {{ $product->name }} en favoritos">♡</button>
                                    </form>
                                @endauth
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded-lg transition shadow-sm">
                                        🛒 Agregar
                                    </button>
                                </form>
                                
                                <form action="{{ route('compare.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-3 rounded-lg transition" title="Comparar">
                                        ⚖️
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Paginación -->
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @else
                <div class="mx-auto max-w-2xl border border-dashed border-emerald-200 bg-emerald-50/50 px-6 py-20 text-center">
                    <div class="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-full bg-white text-emerald-800 shadow-sm" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" /></svg>
                    </div>
                    <h3 class="text-2xl font-bold tracking-tight text-slate-900">El catálogo está listo para crecer</h3>
                    <p class="mx-auto mt-3 max-w-md text-slate-600">Pronto encontrarás productos de agricultores y productores locales.</p>
                    <a href="{{ route('products.index') }}" class="mt-7 inline-flex rounded-lg bg-emerald-800 px-6 py-3 font-bold text-white shadow-sm transition hover:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                        Explorar catálogo
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
