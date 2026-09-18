<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-800 leading-tight">
            {{ __('Mi Granja / Mis Productos') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-green-200">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-700">Inventario Sostenible</h3>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('seller.productos.bulk.create') }}" class="border border-green-600 rounded-md py-2 px-4 inline-flex justify-center text-sm font-medium text-green-700 hover:bg-green-50 focus:outline-none">
                                Cargar varios CSV
                            </a>
                            <a href="{{ route('seller.productos.create') }}" class="bg-green-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-green-700 focus:outline-none">
                                + Publicar producto
                            </a>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 text-green-800 bg-green-200 border border-green-400 p-4 rounded-md font-semibold">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($products->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200 shadow-sm border border-gray-100">
                            <thead class="bg-green-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">
                                        Producto
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">
                                        Stock
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">
                                        Precio / Estatus
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-green-800 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $product->category->name ?? 'General' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->stock > 0)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ $product->stock }} disponibles
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Agotado
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="font-bold text-gray-700">${{ number_format($product->price, 2) }}</div>
                                        <span class="text-xs">{{ $product->is_active ? 'Activo' : 'Inactivo' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end gap-2">
                                        <form action="{{ route('seller.productos.destroy', $product->id) }}" method="POST" onsubmit="return confirm('¿Seguro de retirar este producto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 border border-red-200 bg-red-50 hover:bg-red-100 px-3 py-1 rounded">Retirar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-10 bg-gray-50 rounded border-2 border-dashed border-gray-300">
                            <span class="text-4xl">🌾</span>
                            <p class="text-gray-500 mt-2 font-medium">Aún no has publicado productos.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
