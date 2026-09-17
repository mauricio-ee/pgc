<div x-data="{ open: !localStorage.getItem('cookies-accepted') }" 
     x-show="open" 
     x-transition:enter="transition ease-out duration-500" 
     x-transition:enter-start="opacity-0 translate-y-full" 
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-full"
     class="fixed bottom-0 inset-x-0 pb-2 sm:pb-5 z-50">
  <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
    <div class="p-4 rounded-xl bg-gray-900 shadow-xl border border-gray-700 flex flex-col md:flex-row items-center justify-between gap-4">
      <div class="flex items-center text-white w-full md:w-auto">
        <span class="flex-shrink-0 text-3xl mr-4" role="img" aria-label="cookie">🍪</span>
        <div class="text-sm font-semibold leading-relaxed">
          <strong class="text-green-400">Nuestro compromiso con la privacidad.</strong>
          <p class="mt-1 text-gray-300">Utilizamos cookies propias y de terceros para brindarte una mejor experiencia, mantener tu sesión activa y mejorar nuestro catálogo de compras ecológicas sostenibles. Al continuar navegando, aceptas nuestra <a href="#" class="text-green-300 hover:text-green-500 underline">Política de Cookies</a>.</p>
        </div>
      </div>
      <div class="flex-shrink-0 w-full md:w-auto flex gap-3 mt-2 md:mt-0 justify-end">
        <button type="button" @click="open = false; localStorage.setItem('cookies-accepted', 'false')" class="flex-1 w-full md:w-auto flex items-center justify-center px-4 py-2 border border-gray-600 rounded-md shadow-sm text-sm font-bold text-gray-300 bg-transparent hover:bg-gray-800 transition focus:outline-none">
          Rechazar
        </button>
        <button type="button" @click="open = false; localStorage.setItem('cookies-accepted', 'true')" class="flex-1 w-full md:w-auto flex items-center justify-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-bold text-gray-900 bg-green-400 hover:bg-green-500 transition focus:outline-none">
          Aceptar Cookies
        </button>
      </div>
    </div>
  </div>
</div>
