<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-800 leading-tight">
            Comparar Productos
        </h2>
    </x-slot>

    <div class="py-12 bg-white min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="text-xl font-bold text-gray-800">
                    Estás comparando {{ count($products) }} producto(s)
                </h3>
                
                <div class="flex space-x-3">
                    <a href="{{ route('products.index') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                        ← Volver al catálogo
                    </a>
                    @if(count($products) > 0)
                        <form action="{{ route('compare.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                Limpiar todo
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if(count($products) > 0)
                <div class="overflow-x-auto shadow-sm border border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 bg-white transition-colors">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Características
                                </th>
                                @foreach($products as $product)
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-64">
                                        <div class="flex flex-col items-center">
                                            @if ($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" class="h-24 w-24 object-cover rounded-md mb-2 shadow-sm">
                                            @else
                                                <div class="h-24 w-24 bg-gray-100 flex items-center justify-center rounded-md mb-2 text-3xl">🍃</div>
                                            @endif
                                            <a href="{{ route('products.show', $product->id) }}" class="text-green-600 font-bold hover:underline mb-1">
                                                {{ $product->name }}
                                            </a>
                                            <form action="{{ route('compare.remove', $product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-xs text-red-500 hover:text-red-700 px-2 py-1 bg-red-50 rounded">
                                                    Quitar ❌
                                                </button>
                                            </form>
                                        </div>
                                    </th>
                                @endforeach
                                <!-- Celdas vacías si hay menos de 4 productos y queremos rellenar para que se vea la grilla, opcional -->
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 transition-colors">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 bg-gray-50">
                                    Precio
                                </td>
                                @foreach($products as $product)
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-xl font-bold text-green-700">
                                        ${{ number_format($product->price, 2) }}
                                    </td>
                                @endforeach
                            </tr>
                            
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 bg-gray-50">
                                    Categoría
                                </td>
                                @foreach($products as $product)
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                                        {{ $product->category?->name ?? 'N/A' }}
                                    </td>
                                @endforeach
                            </tr>

                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 bg-gray-50">
                                    Vendedor (Granja)
                                </td>
                                @foreach($products as $product)
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            🧑‍🌾 {{ $product->user->name }}
                                        </span>
                                    </td>
                                @endforeach
                            </tr>

                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 bg-gray-50">
                                    Certificado Eco
                                </td>
                                @foreach($products as $product)
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                                        @if($product->is_eco_certified)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                ✅ Sí
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                ❌ No
                                            </span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>

                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 bg-gray-50">
                                    Descripción / Detalles
                                </td>
                                @foreach($products as $product)
                                    <td class="px-6 py-4 text-sm text-gray-500 text-center min-w-[200px] align-top">
                                        {{ \Illuminate\Support\Str::limit($product->description, 100) ?: 'Sin descripción' }}
                                    </td>
                                @endforeach
                            </tr>

                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 bg-gray-50">
                                    Comprar
                                </td>
                                @foreach($products as $product)
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            
                                            <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Al Carrito
                                            </button>
                                        </form>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-20 bg-green-50 rounded-lg border border-green-200 transition-colors">
                    <span class="text-6xl mb-4 block">⚖️</span>
                    <h2 class="text-2xl font-bold text-green-900 mb-2">Aún no tienes productos para comparar</h2>
                    <p class="text-green-700 mb-6">Explora nuestro catálogo verde y añade productos a la lista de comparación.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Ir al Catálogo
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
