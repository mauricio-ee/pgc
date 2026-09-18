<div x-data="{
        open: false,
        input: '',
        messages: [{ from: 'bot', text: 'Hola, soy el asistente de EcoVenta. ¿En qué puedo ayudarte?' }],
        options: ['¿Cómo compro?', '¿Cuánto tarda el envío?', '¿Qué métodos de pago aceptan?', '¿Dónde veo mi pedido?'],
        answer(question) {
            const normalized = question.toLowerCase();
            let response = 'Puedo ayudarte con compras, envíos, pagos y seguimiento de pedidos. Prueba una de las opciones disponibles.';

            if (normalized.includes('compr')) {
                response = 'Explora el catálogo, abre un producto, elige la cantidad y pulsa "Agregar al carrito". Desde el carrito puedes finalizar la compra.';
            } else if (normalized.includes('env')) {
                response = 'El envío ecológico es gratuito. La disponibilidad y fecha estimada aparecen en la ficha del producto.';
            } else if (normalized.includes('pago')) {
                response = 'Puedes pagar mediante Mercado Pago o transferencia bancaria desde el checkout.';
            } else if (normalized.includes('pedido')) {
                response = 'Puedes consultar tus pedidos y su estado desde "Mis Pedidos" en el menú de tu cuenta.';
            }

            this.messages.push({ from: 'user', text: question });
            this.messages.push({ from: 'bot', text: response });
            this.input = '';
        },
        submit() {
            if (this.input.trim()) this.answer(this.input.trim());
        }
    }" class="fixed bottom-5 right-5 z-50">
    <div x-show="open" x-transition.origin.bottom.right class="mb-3 w-[min( calc(100vw-2rem),_22rem)] overflow-hidden rounded-2xl border border-emerald-200 bg-white shadow-2xl" @click.outside="open = false">
        <div class="flex items-center justify-between bg-emerald-800 px-4 py-3 text-white">
            <div>
                <p class="font-bold">Asistente EcoVenta</p>
                <p class="text-xs text-emerald-100">Ayuda rápida</p>
            </div>
            <button type="button" @click="open = false" class="rounded-md p-1 text-emerald-100 hover:bg-emerald-700 hover:text-white" aria-label="Cerrar asistente">×</button>
        </div>

        <div class="max-h-72 space-y-3 overflow-y-auto bg-slate-50 p-4" aria-live="polite">
            <template x-for="(message, index) in messages" :key="index">
                <div :class="message.from === 'user' ? 'ml-8 bg-emerald-700 text-white' : 'mr-8 bg-white text-slate-700 border border-slate-200'" class="rounded-xl px-3 py-2 text-sm" x-text="message.text"></div>
            </template>
        </div>

        <div class="border-t border-slate-200 bg-white p-3">
            <div class="mb-3 flex gap-2 overflow-x-auto pb-1">
                <template x-for="option in options" :key="option">
                    <button type="button" @click="answer(option)" x-text="option" class="whitespace-nowrap rounded-full border border-emerald-200 px-3 py-1 text-xs font-semibold text-emerald-800 hover:bg-emerald-50"></button>
                </template>
            </div>
            <form @submit.prevent="submit" class="flex gap-2">
                <label for="chatbot-input" class="sr-only">Escribe tu pregunta</label>
                <input id="chatbot-input" x-model="input" type="text" placeholder="Escribe tu pregunta..." class="min-w-0 flex-1 rounded-lg border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                <button type="submit" class="rounded-lg bg-emerald-800 px-3 py-2 text-sm font-bold text-white hover:bg-emerald-900" aria-label="Enviar pregunta">Enviar</button>
            </form>
        </div>
    </div>

    <button type="button" @click="open = !open" class="flex items-center gap-2 rounded-full bg-emerald-800 px-4 py-3 font-bold text-white shadow-lg transition hover:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" :aria-expanded="open.toString()" aria-label="Abrir asistente de ayuda">
        <span class="text-xl" aria-hidden="true">?</span>
        <span class="hidden sm:inline">Ayuda</span>
    </button>
</div>
