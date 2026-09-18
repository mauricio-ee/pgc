<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Administrador Demo
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin Sistema',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );
        $admin->forceFill(['role' => 'admin'])->save();

        // Vendedor Demo
        $vendedor = User::firstOrCreate(
            ['email' => 'vendedor@test.com'],
            [
                'name' => 'Don Manuel (Vendedor)',
                'password' => bcrypt('password'),
                'role' => 'seller',
            ]
        );
        $vendedor->forceFill(['role' => 'seller'])->save();

        // Cliente Demo
        $cliente = User::firstOrCreate(
            ['email' => 'cliente@test.com'],
            [
                'name' => 'Cliente Ecológico',
                'password' => bcrypt('password'),
                'role' => 'customer',
            ]
        );
        $cliente->forceFill(['role' => 'customer'])->save();

        // Certificador Demo
        $certificador = User::firstOrCreate(
            ['email' => 'certificador@test.com'],
            [
                'name' => 'Inspector Ecológico',
                'password' => bcrypt('password'),
                'role' => 'certifier',
            ]
        );
        $certificador->forceFill(['role' => 'certifier'])->save();

        // Insertar más categorías agrícolas
        $categorias = [
            ['name' => 'Frutas Frescas', 'description' => 'Frutas cultivadas sin pesticidas químicos.'],
            ['name' => 'Verduras y Hortalizas', 'description' => 'Verduras orgánicas directas del huerto.'],
            ['name' => 'Lácteos Artesanales', 'description' => 'Leche, quesos y yogures de granjas locales.'],
            ['name' => 'Carnes Orgánicas', 'description' => 'Carne de animales criados en pasturas naturales.'],
            ['name' => 'Cereales y Semillas', 'description' => 'Avena, chia, nueces y semillas variadas.'],
            ['name' => 'Abonos y Fertilizantes', 'description' => 'Compost natural e insumos ecológicos para cultivo.'],
            ['name' => 'Plantas y Plantines', 'description' => 'Plantas listas para transplantar.'],
            ['name' => 'Mermeladas y Conservas', 'description' => 'Elaboración casera y artesanal.'],
        ];

        foreach ($categorias as $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])], // condicional para evitar duplicados
                ['name' => $cat['name'], 'description' => $cat['description']]
            );
        }

        // Perfiles de prueba para validar cada área de la plataforma.
        $perfilesDePrueba = [
            'customer' => 'Cliente de Prueba',
            'seller' => 'Agricultor de Prueba',
            'support' => 'Soporte de Prueba',
            'order_manager' => 'Gestor de Pedidos de Prueba',
            'moderator' => 'Moderador de Prueba',
            'farmer_verifier' => 'Verificador de Agricultores de Prueba',
            'payment_manager' => 'Gestor de Pagos de Prueba',
            'quality_manager' => 'Encargado de Calidad de Prueba',
            'promotion_manager' => 'Gestor de Promociones de Prueba',
            'analyst' => 'Analista de Prueba',
            'admin' => 'Administrador de Prueba',
            'super_admin' => 'Superadministrador de Prueba',
            'technician' => 'Técnico de Prueba',
            'certifier' => 'Certificador de Prueba',
        ];

        foreach ($perfilesDePrueba as $role => $name) {
            User::updateOrCreate(
                ['email' => "prueba-{$role}@ecoventa.test"],
                [
                    'name' => $name,
                    'password' => bcrypt('password'),
                    'role' => $role,
                    'phone' => '3000000000',
                    'bio' => "Perfil de prueba para el rol {$role}.",
                ]
            );
        }

        $vendedoresDePrueba = User::where('role', 'seller')->get();
        $productosDePrueba = [
            ['name' => 'Tomates orgánicos', 'category' => 'Frutas Frescas', 'price' => 12.50, 'stock' => 40, 'description' => 'Tomates frescos cultivados localmente sin pesticidas sintéticos.'],
            ['name' => 'Lechuga hidropónica', 'category' => 'Verduras y Hortalizas', 'price' => 6.00, 'stock' => 35, 'description' => 'Lechuga crujiente, cosechada el mismo día y lista para tus ensaladas.'],
            ['name' => 'Miel artesanal', 'category' => 'Mermeladas y Conservas', 'price' => 18.90, 'stock' => 24, 'description' => 'Miel natural de productores locales, envasada artesanalmente.'],
            ['name' => 'Semillas de chía', 'category' => 'Cereales y Semillas', 'price' => 9.50, 'stock' => 50, 'description' => 'Semillas seleccionadas para complementar una alimentación saludable.'],
            ['name' => 'Compost natural', 'category' => 'Abonos y Fertilizantes', 'price' => 15.00, 'stock' => 18, 'description' => 'Abono orgánico para nutrir huertos y jardines de forma responsable.'],
            ['name' => 'Plantines de albahaca', 'category' => 'Plantas y Plantines', 'price' => 7.25, 'stock' => 30, 'description' => 'Plantines aromáticos listos para cultivar en casa.'],
        ];

        foreach ($vendedoresDePrueba as $vendedorDePrueba) {
            foreach ($productosDePrueba as $productoDePrueba) {
                $category = Category::where('name', $productoDePrueba['category'])->firstOrFail();
                Product::updateOrCreate(
                    ['slug' => Str::slug($productoDePrueba['name']) . '-' . $vendedorDePrueba->id],
                    [
                        'user_id' => $vendedorDePrueba->id,
                        'category_id' => $category->id,
                        'name' => $productoDePrueba['name'],
                        'description' => $productoDePrueba['description'],
                        'price' => $productoDePrueba['price'],
                        'stock' => $productoDePrueba['stock'],
                        'is_eco_certified' => true,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
