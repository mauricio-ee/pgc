<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-800 leading-tight">
            Panel de Certificación Ecológica 🌱
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">¡Éxito!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    <h3 class="text-xl font-bold mb-4">Productos en espera de Revisión</h3>
                    <p class="text-gray-600 mb-6">Revisa estos productos propuestos por agricultores y avala sus prácticas ecológicas.</p>

                    @if($products->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-green-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Producto</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Categoría</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Vendedor</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($products as $product)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if($product->image)
                                                        <img class="h-10 w-10 rounded-full object-cover border border-gray-300 mr-3" src="{{ asset('storage/' . $product->image) }}" alt="">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-lg mr-3">🍃</div>
                                                    @endif
                                                    <a href="{{ route('products.show', $product->id) }}" target="_blank" class="text-sm font-bold text-gray-900 hover:text-green-600 transition">{{ $product->name }}</a>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm text-gray-600">{{ $product->category->name ?? 'General' }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $product->seller->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <form action="{{ route('certifier.certify', $product->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-green-100 hover:bg-green-200 text-green-800 font-bold py-1 px-4 rounded-full border border-green-300 transition" onclick="return confirm('¿Aceptas que este producto cumple con las reglas ecológicas?')">
                                                        Aprobar Sello ✅
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <span class="text-5xl block mb-4">🏆</span>
                            <h4 class="text-xl font-bold text-gray-800">¡Todo al día!</h4>
                            <p class="text-gray-500">No hay productos locales pendientes de revisión de sello ecológico.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
