<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductBulkUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_seller_can_upload_multiple_products_from_csv(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $category = Category::create([
            'name' => 'Frutas Frescas',
            'slug' => 'frutas-frescas',
            'description' => 'Frutas locales',
        ]);

        $csv = UploadedFile::fake()->createWithContent(
            'productos.csv',
            "name,description,price,stock,category\n" .
            "Tomates,Frescos,12.50,20,Frutas Frescas\n" .
            "Manzanas,Locales,8.00,15,frutas-frescas\n"
        );

        $response = $this->actingAs($seller)->post(route('seller.productos.bulk.store'), [
            'file' => $csv,
        ]);

        $response->assertRedirect(route('seller.productos.index'));
        $this->assertDatabaseHas('products', ['name' => 'Tomates', 'category_id' => $category->id, 'user_id' => $seller->id]);
        $this->assertDatabaseHas('products', ['name' => 'Manzanas', 'category_id' => $category->id, 'user_id' => $seller->id]);
        $this->assertSame(2, Product::where('user_id', $seller->id)->count());
    }
}
