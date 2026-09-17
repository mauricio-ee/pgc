<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
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
    }
}
