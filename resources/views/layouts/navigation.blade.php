<nav x-data="{ open: false }" class="bg-white border-b border-emerald-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-[4.5rem]">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-emerald-950 text-xl font-extrabold tracking-tight group">
                        <!-- Carrito verde con una hoja -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-800 group-hover:text-emerald-900 transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <!-- Carrito -->
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            <!-- Hoja ecológica (Eco Leaf) saliendo del carrito -->
                            <path d="M12 4C12 4 10 1 7 1C4 1 3 4 3 6C3 10 12 15 12 15C12 15 21 10 21 6C21 4 20 1 17 1C14 1 12 4 12 4Z" fill="currentColor" class="text-emerald-400 group-hover:text-emerald-500"></path>
                        </svg>
                        Ecoventa
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home') || request()->routeIs('products.index')" class="text-slate-600 hover:text-emerald-800">
                        {{ __('Catálogo Verde') }}
                    </x-nav-link>

                    <!-- Comparar Productos -->
                    @php
                        $compareCount = count(session()->get('compare', []));
                        $cartCount = count(session()->get('cart', []));
                    @endphp
                    <x-nav-link :href="route('compare.index')" :active="request()->routeIs('compare.index')" class="text-slate-600 hover:text-emerald-800">
                        {{ __('Comparar') }} @if($compareCount > 0) <span class="ml-1 bg-green-500 text-white rounded-full px-2 py-0.5 text-xs font-bold">{{ $compareCount }}</span> @endif
                    </x-nav-link>

                    <!-- Carrito de Compras -->
                    <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')" class="text-slate-600 hover:text-emerald-800">
                        {{ __('Carrito') }} 
                        @if($cartCount > 0) 
                            <span class="ml-1 bg-yellow-400 text-green-900 rounded-full px-2 py-0.5 text-xs font-black">{{ $cartCount }}</span> 
                        @else
                            <span class="ml-1 text-emerald-800" aria-hidden="true">+</span>
                        @endif
                    </x-nav-link>

                    @auth
                        <x-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.*')" class="text-slate-600 hover:text-emerald-800">
                            {{ __('Favoritos') }}
                        </x-nav-link>
                    @endauth

                    @auth
                        <!-- Para todos los logueados (Dashboard basico) -->
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-slate-600 hover:text-emerald-800">
                            {{ __('Panel / Inicio') }}
                        </x-nav-link>

                        <!-- Panel de Cliente (Sus Compras) -->
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')" class="text-slate-600 hover:text-emerald-800">
                            {{ __('Mis Pedidos') }}
                        </x-nav-link>

                        <!-- Panel de Vendedor -->
                        @if(Auth::user()->isSeller())
                            <x-nav-link :href="route('seller.productos.index')" :active="request()->routeIs('seller.*')" class="text-slate-600 hover:text-emerald-800">
                                {{ __('Mi Granja (Productos)') }}
                            </x-nav-link>
                        @endif

                        <!-- Panel de Administrador -->
                        @if(Auth::user()->isAdmin())
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-slate-600 hover:text-emerald-800">
                                {{ __('Resumen Admin') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.categorias.index')" :active="request()->routeIs('admin.categorias.*')" class="text-slate-600 hover:text-emerald-800">
                                {{ __('Categorías') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.orders.all')" :active="request()->routeIs('admin.orders.*')" class="text-slate-600 hover:text-emerald-800">
                                {{ __('Todos los Pedidos') }}
                            </x-nav-link>
                        @endif

                        @if(Auth::user()->isStaff() && !Auth::user()->isAdmin())
                            <x-nav-link :href="route('staff.dashboard')" :active="request()->routeIs('staff.*')" class="text-slate-600 hover:text-emerald-800">
                                {{ __('Panel de Equipo') }}
                            </x-nav-link>
                        @endif

                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown y Modo Oscuro -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 border border-emerald-200 text-sm leading-4 font-bold rounded-lg text-emerald-900 bg-emerald-50 hover:bg-emerald-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition shadow-sm ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4 text-green-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Mi Perfil') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Cerrar Sesión') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-800">Acceder</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-semibold text-emerald-800 hover:text-emerald-900">Registrarse</a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" aria-label="Abrir menú" class="inline-flex items-center justify-center p-2 rounded-md text-emerald-800 hover:text-emerald-950 hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-emerald-100">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Catálogo Verde') }}
            </x-responsive-nav-link>

            @auth
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Panel / Inicio') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                {{ __('Mis Pedidos') }}
            </x-responsive-nav-link>
            
            @if(Auth::user()->isSeller())
                <x-responsive-nav-link :href="route('seller.productos.index')" :active="request()->routeIs('seller.*')">
                    {{ __('Mi Granja (Productos)') }}
                </x-responsive-nav-link>
            @endif
            @endauth

            <x-responsive-nav-link :href="route('compare.index')" :active="request()->routeIs('compare.index')">
                {{ __('Comparar Productos') }} @if($compareCount > 0) ({{ $compareCount }}) @endif
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                {{ __('Carrito') }} @if($cartCount > 0) ({{ $cartCount }}) @endif
            </x-responsive-nav-link>

            @auth
            <x-responsive-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.*')">
                {{ __('Favoritos') }}
            </x-responsive-nav-link>
            @if(Auth::user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Resumen Admin') }}
                </x-responsive-nav-link>
            @endif
            @endauth
        </div>

        @auth
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-green-200">
            <div class="px-4">
                <div class="font-medium text-base text-green-900">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-green-700">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Mi Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @else
        <!-- Guest Options -->
        <div class="pt-4 pb-1 border-t border-green-200">
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Ingresar') }}
                </x-responsive-nav-link>
                @if (Route::has('register'))
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Registrarse') }}
                    </x-responsive-nav-link>
                @endif
            </div>
        </div>
        @endauth
    </div>
</nav>

