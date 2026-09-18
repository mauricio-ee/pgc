<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-800">Equipo EcoVenta</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">Panel de trabajo</h2>
        </div>
    </x-slot>

    @php
        $roleLabels = [
            'support' => 'Atención al cliente',
            'order_manager' => 'Gestor de pedidos',
            'moderator' => 'Moderación de contenido',
            'farmer_verifier' => 'Verificación de agricultores',
            'payment_manager' => 'Gestión de pagos',
            'quality_manager' => 'Control de calidad',
            'promotion_manager' => 'Gestión de promociones',
            'analyst' => 'Analítica',
            'super_admin' => 'Superadministración',
            'technician' => 'Soporte técnico',
            'certifier' => 'Certificación ecológica',
        ];
        $roleActions = [
            'support' => ['title' => 'Casos de clientes', 'text' => 'Revisa consultas, incidencias y solicitudes de ayuda.'],
            'order_manager' => ['title' => 'Operaciones de pedidos', 'text' => 'Supervisa preparación, envíos y entregas.'],
            'moderator' => ['title' => 'Contenido pendiente', 'text' => 'Revisa productos, imágenes y reseñas reportadas.'],
            'farmer_verifier' => ['title' => 'Agricultores pendientes', 'text' => 'Valida perfiles y documentación de productores.'],
            'payment_manager' => ['title' => 'Pagos por revisar', 'text' => 'Comprueba transferencias, reembolsos y pagos fallidos.'],
            'quality_manager' => ['title' => 'Control de calidad', 'text' => 'Gestiona incidencias de productos y servicio.'],
            'promotion_manager' => ['title' => 'Campañas activas', 'text' => 'Administra promociones, cupones y productos de temporada.'],
            'analyst' => ['title' => 'Indicadores', 'text' => 'Consulta ventas, pedidos y comportamiento de usuarios.'],
            'super_admin' => ['title' => 'Control del sistema', 'text' => 'Administra permisos, usuarios y configuración global.'],
            'technician' => ['title' => 'Salud técnica', 'text' => 'Supervisa errores, integraciones y disponibilidad.'],
            'certifier' => ['title' => 'Certificaciones', 'text' => 'Revisa y mantiene la validación ecológica de productos.'],
        ];
        $role = auth()->user()->role;
        $action = $roleActions[$role] ?? ['title' => 'Área de trabajo', 'text' => 'Gestiona las tareas asignadas a tu perfil.'];
    @endphp

    <div class="min-h-screen bg-slate-50 py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            <section class="rounded-2xl border border-emerald-100 bg-white p-6 shadow-sm sm:p-8">
                <p class="text-sm font-semibold text-emerald-800">Bienvenido, {{ auth()->user()->name }}</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-900">{{ $roleLabels[$role] ?? 'Equipo EcoVenta' }}</h1>
                <p class="mt-3 max-w-2xl text-slate-600">Este espacio reúne las herramientas y tareas correspondientes a tu perfil dentro de la plataforma.</p>
            </section>

            <section class="grid gap-6 md:grid-cols-3">
                <article class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-wide text-emerald-800">Tu función</p>
                    <h2 class="mt-3 text-xl font-bold text-slate-900">{{ $action['title'] }}</h2>
                    <p class="mt-2 text-slate-600">{{ $action['text'] }}</p>
                </article>
                <article class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-wide text-emerald-800">Acceso</p>
                    <h2 class="mt-3 text-xl font-bold text-slate-900">Permisos activos</h2>
                    <p class="mt-2 text-slate-600">Tu cuenta solo debe acceder a las herramientas de este perfil.</p>
                </article>
                <article class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-wide text-emerald-800">Siguiente paso</p>
                    <h2 class="mt-3 text-xl font-bold text-slate-900">Área en preparación</h2>
                    <p class="mt-2 text-slate-600">Las acciones específicas se añadirán conforme se habiliten los módulos operativos.</p>
                </article>
            </section>
        </div>
    </div>
</x-app-layout>
