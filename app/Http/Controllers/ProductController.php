<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Catálogo Público: Lista todos los productos ecológicos con sus categorías.
     */
    public function index(Request $request)
    {
        // Paginamos para optimizar (12 productos por página)
        // Cargamos las relaciones 'category' y 'user' (Eager Loading) para evitar el error N+1 en las vistas
        $query = Product::with(['category', 'user'])->where('is_active', true);

        $validated = $request->validate([
            'categoria' => ['nullable', 'string', 'max:100'],
            'search' => ['nullable', 'string', 'max:100'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0', 'gte:min_price'],
            'sort' => ['nullable', 'in:latest,price_asc,price_desc,name'],
        ]);

        if (!empty($validated['categoria'])) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->categoria);
            });
        }

        if (!empty($validated['search'])) {
            $search = $validated['search'];
            $query->where(function ($productQuery) use ($search) {
                $productQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('category', fn ($categoryQuery) =>
                        $categoryQuery->where('name', 'like', "%{$search}%")
                    )
                    ->orWhereHas('user', fn ($userQuery) =>
                        $userQuery->where('name', 'like', "%{$search}%")
                    );
            });
        }

        if (isset($validated['min_price'])) {
            $query->where('price', '>=', $validated['min_price']);
        }

        if (isset($validated['max_price'])) {
            $query->where('price', '<=', $validated['max_price']);
        }

        $sort = $validated['sort'] ?? 'latest';
        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name' => $query->orderBy('name'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all(); // Para el filtro lateral

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Panel Vendedor: Listado de sus propios productos.
     */
    public function sellerIndex()
    {
        $products = Product::where('user_id', auth()->id())->latest()->paginate(10);
        return view('products.seller_index', compact('products'));
    }

    /**
     * Panel Vendedor: Formulario para publicar un nuevo producto.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Panel Vendedor: Guarda un producto en DB.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048', // Validación de imagen e injecciones
        ]);

        $product = new Product($request->except('image'));
        $product->user_id = auth()->id(); // Asigna el producto al vendedor autenticado
        $product->slug = Str::slug($request->name) . '-' . uniqid(); // Slug SEO-friendly

        // Manipulación segura del archivo (almacenamiento en /storage/app/public/products)
        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('seller.productos.index')->with('success', 'Producto ecológico publicado exitosamente.');
    }

    /**
     * Catálogo público: Detalles del producto.
     */
    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404, 'Producto no disponible.');
        }

        // Carga también el vendedor para poder mostrar quién produce (fomenta el comercio local local)
        $product->load(['category', 'seller']);
        return view('products.show', compact('product'));
    }

    /**
     * Panel Vendedor: Formulario para editar un producto existente.
     */
    public function edit(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para editar este producto.');
        }

        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Panel Vendedor: Actualizar el producto en DB.
     */
    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $product->fill($request->except('image'));
        $product->slug = Str::slug($request->name) . '-' . uniqid();

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('seller.productos.index')->with('success', 'Producto actualizado.');
    }

    /**
     * Panel Vendedor: Elimina (desactiva) el producto.
     */
    public function destroy(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }
        
        // En un ecommerce es mejor hacer un soft delete ("inactivar") o borrar si no tiene items de ventas 
        $product->delete();

        return redirect()->route('seller.productos.index')->with('success', 'Producto eliminado.');
    }
}
