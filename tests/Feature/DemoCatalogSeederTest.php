<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\DemoCatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoCatalogSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_catalog_is_created_once_without_certification_claims(): void
    {
        $seeder = new DemoCatalogSeeder();
        $seeder->run();
        $seeder->run();

        $products = Product::with('user')->get();

        $this->assertCount(6, $products);
        $this->assertSame(1, User::where('email', 'catalogo-demo@ecoventa.invalid')->count());
        $this->assertSame('seller', $products->first()->user->role);

        foreach ($products as $product) {
            $this->assertSame(1, (int) $product->is_active);
            $this->assertSame(0, (int) $product->is_eco_certified);
            $this->assertStringContainsString('ficticios', $product->description);
        }
    }
}
