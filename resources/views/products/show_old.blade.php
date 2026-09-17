<x-app-layout>
    <x-slot name="header">
        <!-- Breadcrumb style -->
        <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Volver al listado</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="mx-2 text-gray-400">|</span>
                        <span class="text-gray-900 font-semibold">{{ $product->category->name ?? 'Varios' }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <!-- Fondo MercadoLibre style (bg-gray-100/200) -->
    <div class="py-8 bg-[#ebebeb] min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Contenedor Principal (Tarjeta Blanca) -->
            <div class="bg-white rounded-md shadow-sm flex flex-col md:flex-row">
                
                <!-- Columna Izquierda: Imagen y Descripción (≈ 65%) -->
                <div class="md:w-2/3 p-6 md:p-10 pb-12 w-full border-b md:border-b-0 md:border-r border-gray-200">
                    
                    @if(!$product->user)
                        <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                            <h4 class="text-red-800 font-bold text-lg mb-1">Este producto ha sido retirado</h4>
                            <p class="text-sm text-red-700">El agricultor que mantenía este producto ha decidido darse de baja o eliminar su cuenta de Ecoventa. Por regulaciones del mercado, los productos de cuentas inactivas no pueden ser comprados ni añadidos de nuevo al carrito.</p>
                            <div class="mt-4">
                                <a href="{{ route('products.index') }}" class="text-red-700 font-semibold underline hover:text-red-900">Volver al catálogo</a>
                            </div>
                        </div>
                    @endif

                    <!-- Imagen -->
                    <div class="relative flex items-center justify-center min-h-[400px] mb-8">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Foto de {{ $product->name }}" class="object-contain h-[500px] w-full">
                        @else
                            <div class="text-gray-200">
                                <svg class="w-48 h-48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>
                            </div>
                        @endif
                        
                        @if($product->is_eco_certified)
                            <div class="absolute top-4 left-4 bg-green-100 text-green-800 text-xs px-2 py-1 items-center gap-1 font-semibold rounded-sm">
                               <span class="text-green-600">🌿</span> Certificado Ecológico
                            </div>
                        @endif
                    </div>

                    <hr class="border-gray-200 my-10">

                    <!-- Características / "Lo que tenés que saber" -->
                    <div class="mb-10">
                        <h2 class="text-2xl font-normal text-gray-900 mb-6">Lo que tenés que saber de este producto</h2>
                        <ul class="text-sm text-gray-700 space-y-4">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Producto local de <span class="font-semibold">{{ $product->user->name ?? 'Cuenta de Productor Eliminada' }}</span>.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Categoría: <span class="font-semibold">{{ $product->category->name ?? 'Varios' }}</span>.</span>
                            </li>
                            @if($product->is_eco_certified)
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Cuenta con <span class="font-semibold text-green-700">certificación ecológica</span> verificada.</span>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <hr class="border-gray-200 my-10">

                    <!-- Descripción -->
                    <div>
                        <h2 class="text-2xl font-normal text-gray-900 mb-6">Descripción</h2>
                        <div class="text-gray-600 text-lg leading-relaxed font-light">
                            <!-- Usamos nl2br junto con e() para sanitizar pero respetar los saltos de línea -->
                            <p>{!! nl2br(e($product->description)) !!}</p>
                        </div>

                        <hr class="border-gray-200 my-10">

                        <!-- SECCIÓN DE RESEÑAS Y VALORACIONES ECOLÓGICAS Y COMUNITARIAS -->
                        <div id="reviews-section" class="mt-8">
                            <h2 class="text-2xl font-normal text-gray-900 mb-6">Reseñas del producto</h2>

                            <div class="flex items-center gap-4 mb-8">
                                <h3 class="text-5xl font-light text-gray-900">{{ number_format($product->averageRating(), 1) }}</h3>
                                <div>
                                    <div class="flex text-[#3483fa] text-lg">
                                        @for($i=1; $i<=5; $i++)
                                            @if($i <= round($product->averageRating()))
                                                ★
                                            @else
                                                <span class="text-gray-300">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $product->reviews->count() }} calificaciones de la comunidad</span>
                                </div>
                            </div>

                            <!-- Listado de reseñas -->
                            @if($product->reviews->count() > 0)
                                <div class="space-y-6 mb-8">
                                    @foreach($product->reviews()->latest()->take(5)->get() as $review)
                                    <div class="border-b border-gray-100 pb-6">
                                        <div class="flex text-[#3483fa] text-sm mb-2">
                                            @for($i=1; $i<=5; $i++)
                                                @if($i <= $review->rating) ★ @else <span class="text-gray-200">★</span> @endif
                                            @endfor
                                        </div>
                                        <p class="text-gray-800 text-[15px] leading-relaxed">{{ $review->comment }}</p>
                                        <div class="flex items-center gap-2 mt-2">
                                            <div class="w-6 h-6 bg-green-100 text-green-700 rounded-full flex items-center justify-center text-xs font-bold">{{ substr($review->user->name, 0, 1) }}</div>
                                            <span class="text-xs text-gray-500">{{ $review->user->name }} • {{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-gray-50 p-6 rounded-lg text-center mb-8">
                                    <span class="text-3xl block mb-2">🌿</span>
                                    <p class="text-gray-600 text-sm">Este producto aún no tiene reseñas. Sé el primero de la comunidad en probarlo y dar tu opinión.</p>
                                </div>
                            @endif

                            <!-- Formulario de reseña (Solo usuarios autenticados) -->
                            @auth
                                <div class="bg-blue-50/50 p-6 rounded-lg border border-blue-100">
                                    <h4 class="font-semibold text-gray-900 mb-4">Escribe tu opinión</h4>
                                    <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                                        @csrf
                                        
                                        <!-- Error al enviar dos reseñas -->
                                        @error('review')
                                            <div class="bg-red-50 text-red-600 p-3 rounded mb-4 text-sm font-semibold">{{ $message }}</div>
                                        @enderror

                                        <div class="mb-4">
                                            <label class="block text-sm text-gray-700 mb-2 font-medium">Calificación (Estrellas)</label>
                                            <select name="rating" class="border-gray-300 rounded-md text-sm w-full md:w-1/3 focus:ring-[#3483fa] focus:border-[#3483fa]">
                                                <option value="5">⭐⭐⭐⭐⭐ Excelente</option>
                                                <option value="4">⭐⭐⭐⭐ Muy Bueno</option>
                                                <option value="3">⭐⭐⭐ Bueno</option>
                                                <option value="2">⭐⭐ Regular</option>
                                                <option value="1">⭐ Malo</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm text-gray-700 mb-2 font-medium">Comentario (Opcional)</label>
                                            <textarea name="comment" rows="3" class="w-full border-gray-300 rounded-md text-sm focus:ring-[#3483fa] focus:border-[#3483fa]" placeholder="¿Qué te pareció la calidad? ¿Llegó fresco?"></textarea>
                                        </div>
                                        <button type="submit" class="bg-[#3483fa] hover:bg-[#2968c8] text-white px-6 py-2 rounded-md font-semibold text-[14px] transition-colors">
                                            Publicar reseña
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="bg-gray-50 border border-gray-200 p-4 rounded-md text-center">
                                    <p class="text-sm text-gray-600 mb-2">Para calificar a nuestros agricultores debes iniciar sesión.</p>
                                    <a href="{{ route('login') }}" class="text-[#3483fa] font-semibold hover:underline text-sm">Ingresar ahora</a>
                                </div>
                            @endauth
                        </div>

                        <hr class="border-gray-200 my-10">

                        <!-- Beneficios -->
                        <div>
                            <h2 class="text-2xl font-normal text-gray-900 mb-6">Por qué elegir productos ecológicos</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="flex items-start gap-4">
                                    <div class="bg-green-100 p-2 rounded-full text-green-600 flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-gray-900 font-semibold text-[15px]">Más saludables</h4>
                                        <p class="text-gray-600 text-[14px] mt-1 leading-relaxed">Cultivados sin pesticidas ni químicos sintéticos, cuidando tu bienestar.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="bg-green-100 p-2 rounded-full text-green-600 flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-gray-900 font-semibold text-[15px]">Impacto Ambiental</h4>
                                        <p class="text-gray-600 text-[14px] mt-1 leading-relaxed">Protegen la biodiversidad y reducen la contaminación de la tierra y el agua.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="bg-green-100 p-2 rounded-full text-green-600 flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-gray-900 font-semibold text-[15px]">Mejor sabor</h4>
                                        <p class="text-gray-600 text-[14px] mt-1 leading-relaxed">Conservan su estado natural y organoléptico genuino, ofreciendo aromas más puros.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="bg-green-100 p-2 rounded-full text-green-600 flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-gray-900 font-semibold text-[15px]">Apoyo local</h4>
                                        <p class="text-gray-600 text-[14px] mt-1 leading-relaxed">Fomentas el comercio directo con granjeros y el desarrollo productivo de comunidades.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Compra rápida desde descripción -->
                        @if($product->stock > 0)
                            <div class="mt-10 pt-8 border-t border-gray-200">
                                <h3 class="text-[18px] font-semibold text-gray-900 mb-4">¿Te interesa este producto?</h3>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-4">
                                    @csrf
                                    <div class="flex items-center gap-2 w-full sm:w-auto">
                                        <label for="quantity_desc" class="text-[15px] font-medium text-gray-700">Cantidad:</label>
                                        <select name="quantity" id="quantity_desc" class="bg-gray-100 border-none rounded-md py-2.5 pl-3 pr-8 text-[15px] text-gray-900 font-semibold focus:ring-0 cursor-pointer shadow-sm w-full sm:w-24">
                                            @for ($i = 1; $i <= min($product->stock, 6); $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <button type="submit" class="w-full sm:w-auto px-8 bg-[#3483fa] hover:bg-[#2968c8] text-white font-semibold py-2.5 rounded-md transition-colors text-[16px] shadow-sm">
                                        Añadir al carrito
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                </div>

                <!-- Columna Derecha: Buy Box (≈ 35%) -->
                <div class="md:w-1/3 p-4 md:p-6 w-full">
                    
                    <div class="border border-gray-200 rounded-lg p-5 bg-white mb-6">
                        <div class="text-xs text-gray-500 mb-2">Nuevo | +50 vendidos</div>
                        <h1 class="text-[22px] font-bold text-gray-900 mb-2 leading-tight">{{ $product->name }}</h1>
                        
                        <div class="mb-4 flex items-center">
                            <!-- Estrellas Dinámicas -->
                            <div class="flex text-[#3483fa] text-sm">
                                @for($i=1; $i<=5; $i++)
                                    @if($i <= round($product->averageRating()))
                                        ★
                                    @else
                                        <span class="text-gray-300">★</span>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-[13px] text-gray-500 ml-2">({{ $product->reviews->count() ?? '0' }})</span>
                            <a href="#reviews-section" class="text-[13px] text-[#3483fa] hover:underline ml-2 hidden lg:inline">Ver opiniones</a>
                        </div>

                        <div class="mb-2">
                            <span class="text-4xl font-light text-gray-900">${{ number_format($product->price, 2) }}</span>
                        </div>
                        <div class="text-sm text-gray-900 mb-6">
                            en <span class="font-semibold text-green-600">12 cuotas de ${{ number_format($product->price / 12, 2) }}</span>
                        </div>

                        <div class="mb-6">
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <span class="text-green-600 font-semibold text-[15px]">Llega gratis mañana</span>
                                    <p class="text-[13px] text-gray-500 mt-1">Comprando dentro de las próximas 4 hs</p>
                                </div>
                            </div>
                        </div>

                        <!-- Vendedor info -->
                        <div class="mb-6 pt-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden flex items-center justify-center">
                                    @if($product->user && $product->user->avatar)
                                        <img src="{{ asset('storage/' . $product->user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Vendido por</p>
                                    <p class="text-[15px] text-gray-900 font-semibold">{{ $product->user->name ?? 'Productor Inactivo' }}</p>
                                    <p class="text-xs text-[#3483fa] font-semibold mt-0.5">Agricultor Local</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6 pt-4">
                            <span class="text-[15px] font-semibold text-gray-900 block mb-3">Stock disponible</span>
                            @if($product->stock > 0 && $product->user)
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="flex items-center gap-2 mb-6">
                                        <span class="text-[15px] text-gray-900 font-semibold">Cantidad:</span>
                                        <div class="relative">
                                            <select name="quantity" class="bg-gray-100 border-none rounded-md py-1 pl-2 pr-8 text-[15px] text-gray-900 font-semibold focus:ring-0 cursor-pointer shadow-sm">
                                                @for ($i = 1; $i <= min($product->stock, 6); $i++)
                                                    <option value="{{ $i }}">{{ $i }} unidad{{ $i>1 ? 'es' : '' }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <span class="text-[13px] text-gray-500 font-normal">({{ $product->stock }} disponibles)</span>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        <button type="submit" class="w-full bg-[#3483fa] hover:bg-[#2968c8] text-white font-semibold py-3 rounded-md transition-colors text-[16px] shadow-sm">
                                            Comprar ahora
                                        </button>
                                        <button type="submit" class="w-full bg-[#e3edfb] hover:bg-[#c9defe] text-[#3483fa] font-semibold py-3 rounded-md transition-colors text-[16px]">
                                            Agregar al carrito
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="text-sm text-red-600 font-semibold mt-2 mb-4">Stock agotado temporalmente</div>
                                <button disabled class="w-full bg-gray-200 text-gray-400 font-semibold py-3 rounded-md cursor-not-allowed">
                                    Comprar ahora
                                </button>
                            @endif
                        </div>

                        <div class="space-y-4 text-[13px] text-gray-500 pt-4 border-t border-gray-200">
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                <div><a href="#" class="text-[#3483fa] hover:underline">Compra Protegida</a>, recibí el producto que esperabas o te devolvemos tu dinero.</div>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div><a href="#" class="text-[#3483fa] hover:underline">Mercado Puntos</a>. Sumás 150 puntos.</div>
                            </div>
                        </div>

                    </div>

                    <!-- Información ampliada del vendedor -->
                    <div class="border border-gray-200 rounded-lg p-5 bg-white">
                        <h3 class="text-[18px] font-normal text-gray-900 mb-5">Información sobre el vendedor</h3>
                        
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-gray-900 font-semibold">{{ $product->seller->name ?? 'Granjero anónimo' }}</span>
                        </div>

                        <!-- Stats visuales ML -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-1 space-y-1">
                                <div class="h-2 w-full bg-[#fff0f0]"></div>
                            </div>
                            <div class="flex-1 space-y-1 ml-1">
                                <div class="h-2 w-full bg-[#fff5e8]"></div>
                            </div>
                            <div class="flex-1 space-y-1 ml-1">
                                <div class="h-2 w-full bg-[#fffcda]"></div>
                            </div>
                            <div class="flex-1 space-y-1 ml-1">
                                <div class="h-2 w-full bg-[#f1fdd7]"></div>
                            </div>
                            <div class="flex-1 space-y-1 ml-1 relative">
                                <div class="h-3 w-full bg-[#39b54a] rounded-sm relative -top-0.5"></div>
                            </div>
                        </div>

                        <div class="flex justify-between gap-1 mb-4 mt-2">
                            <div class="text-center w-1/3">
                                <strong class="text-xl block text-gray-900">450</strong>
                                <span class="text-[11px] text-gray-500 leading-tight block mt-1">Ventas en los últimos <br>60 días</span>
                            </div>
                            <div class="text-center border-l border-r border-gray-200 px-1 w-1/3">
                                <svg class="w-6 h-6 text-gray-800 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                <span class="text-[11px] text-gray-500 leading-tight block mt-1">Brinda buena <br>atención</span>
                            </div>
                            <div class="text-center w-1/3">
                                <svg class="w-6 h-6 text-gray-800 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-[11px] text-gray-500 leading-tight block mt-1">Despacha sus productos <br>a tiempo</span>
                            </div>
                        </div>

                        <a href="#" class="text-[14px] font-semibold text-[#3483fa] hover:text-[#2968c8] block mt-6">Ver más datos de este vendedor</a>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
</x-app-layout>
