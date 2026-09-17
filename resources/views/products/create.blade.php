<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-green-800 leading-tight">
            Vender un Producto Nuevo
        </h2>
        <p class="text-green-700 text-lg mt-2">Completa este formulario sencillo para publicar tu producto en la tienda.</p>
    </x-slot>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-green-50 overflow-hidden shadow-sm sm:rounded-lg border border-green-200 p-8">
                <!-- Manejador de errores para seguridad de formularios -->
                @if ($errors->any())
                    <div class="mb-4 text-red-600 bg-red-100 p-4 rounded-md">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('seller.productos.store') }}" enctype="multipart/form-data">
                    @csrf <!-- Protección CSRF -->

                    <!-- Nombre y Categoría -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <label for="name" class="block text-lg font-bold text-green-900 mb-1">1. ¿Cómo se llama el producto?</label>
                            <input type="text" id="name" name="name" class="mt-1 flex w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-lg p-3" value="{{ old('name') }}" placeholder="Ejemplo: Tomates Cherrys Frescos" required>
                        </div>
                        
                        <div>
                            <label for="category_id" class="block text-lg font-bold text-green-900 mb-1">2. ¿Qué tipo de producto es?</label>
                            <select id="category_id" name="category_id" class="mt-1 flex w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-lg p-3 cursor-pointer" required>
                                <option value="">Toca aquí para elegir una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Precio y Stock -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <label for="price" class="block text-lg font-bold text-green-900 mb-1">3. ¿Qué precio tiene? ($)</label>
                            <p class="text-gray-600 text-sm mb-2">Escribe el precio sin puntos ni símbolos raros.</p>
                            <input type="number" step="0.01" id="price" name="price" class="flex w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-lg p-3" value="{{ old('price') }}" placeholder="Ejemplo: 15.50" required>
                        </div>
                        
                        <div>
                            <label for="stock" class="block text-lg font-bold text-green-900 mb-1">4. ¿Cuántas unidades tienes para vender?</label>
                            <p class="text-gray-600 text-sm mb-2">Solo números enteros (ej. 10).</p>
                            <input type="number" id="stock" name="stock" class="flex w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-lg p-3" value="{{ old('stock') }}" placeholder="Ejemplo: 20" required>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-8">
                        <label for="description" class="block text-lg font-bold text-green-900 mb-1">5. Cuéntanos sobre el producto</label>
                        <p class="text-gray-600 text-sm mb-2">Explica cómo lo cultivaste, de dónde viene o qué lo hace especial.</p>
                        <textarea id="description" name="description" rows="4" class="flex w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-lg p-3" placeholder="Escribe aquí los detalles..." required>{{ old('description') }}</textarea>
                    </div>

                    <!-- Imagen -->
                    <div class="mb-8 p-6 bg-white rounded-lg border-2 border-dashed border-green-400">
                        <label class="block text-lg font-bold text-green-900 mb-2">6. Sube una foto de tu producto</label>
                        <p class="text-gray-600 text-base mb-4">Los clientes confían más cuando ven el producto real.</p>
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <label for="image" class="cursor-pointer py-4 px-8 rounded-lg border-2 border-green-600 text-lg font-bold bg-green-100 text-green-800 hover:bg-green-200 transition-colors shadow-sm text-center w-full sm:w-auto">
                                📷 Toca aquí para elegir la foto
                            </label>
                            <span id="file-name" class="text-lg text-gray-700 font-medium">Ninguna foto seleccionada aún</span>
                            <input type="file" id="image" name="image" accept="image/*" class="hidden" onchange="document.getElementById('file-name').textContent = this.files[0] ? '✅ Foto seleccionada: ' + this.files[0].name : 'Ninguna foto seleccionada aún'">
                        </div>
                    </div>

                    <!-- Etiqueta Eco -->
                    <div class="mb-8 flex items-start bg-green-100 p-4 rounded-lg border border-green-300">
                        <input type="hidden" name="is_eco_certified" value="1">
                        <input type="checkbox" id="is_eco_certified_display" class="rounded border-green-400 text-green-600 focus:ring-green-500 w-8 h-8 mt-1" checked disabled>
                        <label for="is_eco_certified_display" class="ml-4 block text-lg font-bold text-green-900 leading-snug">
                            Prometo que este producto fue cultivado de forma natural o ecológica.
                        </label>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-end mt-8 gap-4">
                        <a href="{{ route('seller.productos.index') }}" class="text-lg text-gray-600 hover:text-green-900 underline font-medium">Volver sin guardar</a>
                        <button type="submit" class="w-full sm:w-auto bg-green-700 hover:bg-green-800 text-white text-xl font-bold py-4 px-8 rounded-lg transition duration-200 shadow-lg">
                            ✅ Guardar y Publicar mi Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

