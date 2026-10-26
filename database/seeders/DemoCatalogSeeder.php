<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $seller = User::firstOrCreate(
            ['email' => 'catalogo-demo@ecoventa.invalid'],
            [
                'name' => 'Productor de demostración',
                'password' => Hash::make(Str::random(64)),
                'role' => 'seller',
                'bio' => 'Perfil y productos de demostración académica; no representan una oferta comercial real.',
            ]
        );

        $products = [
            [
                'slug' => 'demo-tomates-organicos',
                'image' => 'demo/tomatoes.svg',
                'name' => 'Tomates orgánicos',
                'category' => 'Frutas Frescas',
                'price' => 4500,
                'stock' => 40,
                'description' => 'Tomates frescos de ejemplo para mostrar el catálogo. Precio e inventario ficticios; no es una oferta comercial real.',
            ],
            [
                'slug' => 'demo-lechuga-hidroponica',
                'image' => 'demo/lettuce.svg',
                'name' => 'Lechuga hidropónica',
                'category' => 'Verduras y Hortalizas',
                'price' => 3000,
                'stock' => 35,
                'description' => 'Lechuga de ejemplo para mostrar el catálogo. Precio e inventario ficticios; no es una oferta comercial real.',
            ],
            [
                'slug' => 'demo-miel-artesanal',
                'image' => 'demo/honey.svg',
                'name' => 'Miel artesanal',
                'category' => 'Mieles y Conservas',
                'price' => 18000,
                'stock' => 24,
                'description' => 'Miel de ejemplo para mostrar el catálogo. Precio e inventario ficticios; no es una oferta comercial real.',
            ],
            [
                'slug' => 'demo-semillas-de-chia',
                'image' => 'demo/chia.svg',
                'name' => 'Semillas de chía',
                'category' => 'Cereales y Semillas',
                'price' => 12000,
                'stock' => 50,
                'description' => 'Semillas de ejemplo para mostrar el catálogo. Precio e inventario ficticios; no es una oferta comercial real.',
            ],
            [
                'slug' => 'demo-compost-natural',
                'image' => 'demo/compost.svg',
                'name' => 'Compost natural',
                'category' => 'Abonos y Fertilizantes',
                'price' => 10000,
                'stock' => 18,
                'description' => 'Compost de ejemplo para mostrar el catálogo. Precio e inventario ficticios; no es una oferta comercial real.',
            ],
            [
                'slug' => 'demo-plantines-de-albahaca',
                'image' => 'demo/basil.svg',
                'name' => 'Plantines de albahaca',
                'category' => 'Plantas y Plantines',
                'price' => 2500,
                'stock' => 30,
                'description' => 'Plantines de ejemplo para mostrar el catálogo. Precio e inventario ficticios; no es una oferta comercial real.',
            ],
        ];

        foreach ($products as $product) {
            $category = Category::firstOrCreate(
                ['slug' => Str::slug($product['category'])],
                ['name' => $product['category'], 'description' => 'Categoría para productos del catálogo EcoVenta.']
            );

            Product::updateOrCreate(
                ['slug' => $product['slug']],
                [
                    'user_id' => $seller->id,
                    'category_id' => $category->id,
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'image' => $product['image'],
                    'is_eco_certified' => false,
                    'is_active' => true,
                ]
            );
        }
    }
}
