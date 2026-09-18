<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-800">Mi Granja</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">Cargar varios productos</h2>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-emerald-100 bg-white p-6 shadow-sm sm:p-8">
                <h1 class="text-2xl font-bold text-slate-900">Importar inventario desde CSV</h1>
                <p class="mt-2 text-slate-600">Puedes publicar hasta 100 productos en una sola carga. Todos se crearán como activos y ecológicos.</p>

                @if ($errors->any())
                    <div class="mt-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700" role="alert">
                        <p class="font-bold">No se pudo completar la carga:</p>
                        <ul class="mt-2 list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mt-6 rounded-xl bg-emerald-50 p-5 text-sm text-emerald-950">
                    <p class="font-bold">Columnas obligatorias</p>
                    <code class="mt-2 block overflow-x-auto rounded bg-white px-3 py-2 text-xs">name,description,price,stock,category</code>
                    <p class="mt-3">La categoría puede ser su nombre o slug. Ejemplo: <strong>Frutas Frescas</strong> o <strong>frutas-frescas</strong>.</p>
                    <a href="data:text/csv;charset=utf-8,name%2Cdescription%2Cprice%2Cstock%2Ccategory%0ATomates%20org%C3%A1nicos%2CFrescos%20y%20cultivados%20localmente%2C12.50%2C20%2CFrutas%20Frescas" download="plantilla-productos.csv" class="mt-3 inline-flex font-semibold text-emerald-800 underline underline-offset-4">Descargar plantilla CSV</a>
                </div>

                <form action="{{ route('seller.productos.bulk.store') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-6">
                    @csrf
                    <div>
                        <label for="file" class="block text-sm font-bold text-slate-900">Archivo CSV</label>
                        <input id="file" name="file" type="file" accept=".csv,.txt,text/csv" required class="mt-2 block w-full rounded-lg border border-slate-300 bg-white px-3 py-3 text-sm text-slate-700 file:mr-4 file:rounded-md file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:font-semibold file:text-emerald-800">
                        <p class="mt-2 text-xs text-slate-500">Máximo 2 MB. Usa comas como separador y guarda el archivo en UTF-8.</p>
                    </div>
                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <a href="{{ route('seller.productos.index') }}" class="rounded-lg px-5 py-3 text-center text-sm font-semibold text-slate-600 underline underline-offset-4 hover:text-slate-900">Cancelar</a>
                        <button type="submit" class="rounded-lg bg-emerald-800 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-emerald-900">Validar y publicar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
