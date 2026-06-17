<?php

namespace Tests\Feature;

use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ProductCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_can_search_filter_and_sort_products(): void
    {
        $electronics = Category::factory()->create([
            'name' => 'Electronics',
            'slug' => 'electronics',
        ]);

        $fashion = Category::factory()->create([
            'name' => 'Fashion',
            'slug' => 'fashion',
        ]);

        $smartphone = Product::factory()->create([
            'name' => 'Smart Phone',
            'slug' => 'smart-phone',
            'description' => 'Portable phone with a large screen.',
            'price' => 200.00,
            'stock_quantity' => 10,
            'is_available' => true,
        ]);

        $laptop = Product::factory()->create([
            'name' => 'Laptop',
            'slug' => 'laptop',
            'description' => 'Powerful portable computer.',
            'price' => 1200.00,
            'stock_quantity' => 5,
            'is_available' => true,
        ]);

        $shirt = Product::factory()->create([
            'name' => 'Shirt',
            'slug' => 'shirt',
            'description' => 'Cotton shirt for daily wear.',
            'price' => 50.00,
            'stock_quantity' => 25,
            'is_available' => true,
        ]);

        $smartphone->categories()->attach($electronics);
        $laptop->categories()->attach($electronics);
        $shirt->categories()->attach($fashion);

        $response = $this->get('/products?category=electronics&sort=price_asc');

        $response->assertOk();
        $response->assertSeeInOrder(['Smart Phone', 'Laptop']);
        $response->assertDontSee('Shirt');
    }

    public function test_product_show_page_displays_categories_and_description(): void
    {
        $electronics = Category::factory()->create([
            'name' => 'Electronics',
            'slug' => 'electronics',
        ]);

        $product = Product::factory()->create([
            'name' => 'Smart Phone',
            'slug' => 'smart-phone',
            'description' => 'Portable phone with a large screen.',
            'price' => 200.00,
            'stock_quantity' => 10,
            'is_available' => true,
        ]);

        $product->categories()->attach($electronics);

        $response = $this->get(route('products.show', $product));

        $response->assertOk();
        $response->assertSee('Smart Phone');
        $response->assertSee('Electronics');
        $response->assertSee('Portable phone with a large screen.');
    }

    public function test_product_image_validation_accepts_only_jpg_and_png_up_to_two_megabytes(): void
    {
        $valid = Validator::make([
            'name' => 'Demo product',
            'slug' => 'demo-product',
            'description' => 'Demo description',
            'price' => 99.99,
            'image' => UploadedFile::fake()->image('demo.png', 800, 600),
            'stock_quantity' => 1,
            'is_available' => true,
            'categories' => [],
        ], (new StoreProductRequest())->rules());

        $this->assertFalse($valid->fails());

        $invalid = Validator::make([
            'name' => 'Demo product',
            'slug' => 'demo-product-2',
            'description' => 'Demo description',
            'price' => 99.99,
            'image' => UploadedFile::fake()->create('demo.gif', 100),
            'stock_quantity' => 1,
            'is_available' => true,
            'categories' => [],
        ], (new StoreProductRequest())->rules());

        $this->assertTrue($invalid->fails());
    }
}
