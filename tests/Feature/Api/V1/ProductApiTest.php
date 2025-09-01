<?php

namespace Tests\Feature\Api\V1;

use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    public function test_can_list_products(): void
    {
        Product::factory()->count(3)->create([
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'current_page',
                        'data' => [
                            '*' => [
                                'id',
                                'product_name',
                                'slug',
                                'sku',
                                'sale_price',
                                'compare_price',
                                'quantity',
                                'published',
                                'created_at',
                                'updated_at'
                            ]
                        ],
                        'total',
                        'per_page'
                    ]
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'Products retrieved successfully'
                ]);

        $this->assertEquals(3, $response->json('data.total'));
    }

    public function test_can_filter_products_by_published_status(): void
    {
        Product::factory()->create([
            'published' => true,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);
        
        Product::factory()->create([
            'published' => false,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?published=true');

        $response->assertStatus(200);
        $this->assertEquals(1, $response->json('data.total'));
        $this->assertTrue($response->json('data.data.0.published'));
    }

    public function test_can_search_products(): void
    {
        Product::factory()->create([
            'product_name' => 'Special Product',
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?search=Special');

        $response->assertStatus(200);
        $this->assertEquals(1, $response->json('data.total'));
        $this->assertStringContainsString('Special', $response->json('data.data.0.product_name'));
    }

    public function test_can_get_single_product(): void
    {
        $product = Product::factory()->create([
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products/' . $product->id);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'product_name',
                        'slug',
                        'sku',
                        'sale_price',
                        'compare_price',
                        'quantity',
                        'published',
                        'created_at',
                        'updated_at'
                    ]
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'Product retrieved successfully',
                    'data' => [
                        'id' => $product->id,
                        'product_name' => $product->product_name,
                        'slug' => $product->slug,
                    ]
                ]);
    }

    public function test_can_create_product(): void
    {
        $productData = [
            'product_name' => 'New Test Product',
            'slug' => 'new-test-product',
            'sku' => 'SKU-001',
            'sale_price' => 29.99,
            'compare_price' => 39.99,
            'quantity' => 100,
            'short_description' => 'A test product',
            'product_description' => 'Full description of test product',
            'published' => true,
            'disable_out_of_stock' => false,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/v1/products', $productData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'product_name',
                        'slug',
                        'sku',
                        'sale_price',
                        'compare_price',
                        'quantity',
                        'published',
                        'created_at',
                        'updated_at'
                    ]
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'Product created successfully',
                    'data' => [
                        'product_name' => 'New Test Product',
                        'slug' => 'new-test-product',
                        'sku' => 'SKU-001',
                        'sale_price' => '29.99',
                        'compare_price' => '39.99',
                        'quantity' => 100,
                        'published' => true,
                    ]
                ]);

        $this->assertDatabaseHas('products', [
            'product_name' => 'New Test Product',
            'slug' => 'new-test-product',
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);
    }

    public function test_can_create_product_with_relationships(): void
    {
        $category = Category::factory()->create();
        $tag = Tag::factory()->create();
        $supplier = Supplier::factory()->create();

        $productData = [
            'product_name' => 'Product with Relationships',
            'slug' => 'product-with-relationships',
            'sku' => 'SKU-REL-001',
            'sale_price' => 49.99,
            'compare_price' => 59.99,
            'quantity' => 50,
            'short_description' => 'A product with relationships',
            'product_description' => 'Full description',
            'published' => true,
            'disable_out_of_stock' => false,
            'categories' => [$category->id],
            'tags' => [$tag->id],
            'suppliers' => [$supplier->id],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/v1/products', $productData);

        $response->assertStatus(201);

        $productId = $response->json('data.id');
        
        // Verify relationships are created
        $this->assertDatabaseHas('product_categories', [
            'category_id' => $category->id,
            'product_id' => $productId,
        ]);
        
        $this->assertDatabaseHas('product_tags', [
            'tag_id' => $tag->id,
            'product_id' => $productId,
        ]);
        
        $this->assertDatabaseHas('product_suppliers', [
            'supplier_id' => $supplier->id,
            'product_id' => $productId,
        ]);
    }

    public function test_cannot_create_product_with_invalid_data(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/v1/products', [
            'product_name' => '',
            'sale_price' => 'invalid-price',
            'quantity' => -5,
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors([
                    'product_name',
                    'sale_price',
                    'quantity',
                    'slug',
                    'compare_price',
                    'short_description',
                    'product_description',
                    'published',
                    'disable_out_of_stock'
                ]);
    }

    public function test_can_update_product(): void
    {
        $product = Product::factory()->create([
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $updateData = [
            'product_name' => 'Updated Product Name',
            'slug' => 'updated-product-name',
            'sale_price' => 44.99,
            'compare_price' => 54.99,
            'quantity' => 50,
            'short_description' => 'Updated short description',
            'product_description' => 'Updated full description',
            'published' => false,
            'disable_out_of_stock' => true,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->putJson('/api/v1/products/' . $product->id, $updateData);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Product updated successfully',
                    'data' => [
                        'product_name' => 'Updated Product Name',
                        'sale_price' => '44.99',
                        'published' => false,
                    ]
                ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'product_name' => 'Updated Product Name',
            'sale_price' => '44.99',
            'published' => false,
            'updated_by' => $this->user->id,
        ]);
    }

    public function test_can_update_product_relationships(): void
    {
        $product = Product::factory()->create([
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);
        
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();
        $tag = Tag::factory()->create();

        $updateData = [
            'product_name' => $product->product_name,
            'slug' => $product->slug,
            'sale_price' => $product->sale_price,
            'compare_price' => $product->compare_price,
            'quantity' => $product->quantity,
            'short_description' => $product->short_description,
            'product_description' => $product->product_description,
            'published' => $product->published,
            'disable_out_of_stock' => $product->disable_out_of_stock,
            'categories' => [$category1->id, $category2->id],
            'tags' => [$tag->id],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->putJson('/api/v1/products/' . $product->id, $updateData);

        $response->assertStatus(200);

        // Verify relationships are updated
        $this->assertDatabaseHas('product_categories', [
            'category_id' => $category1->id,
            'product_id' => $product->id,
        ]);
        
        $this->assertDatabaseHas('product_categories', [
            'category_id' => $category2->id,
            'product_id' => $product->id,
        ]);
        
        $this->assertDatabaseHas('product_tags', [
            'tag_id' => $tag->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_can_delete_product(): void
    {
        $product = Product::factory()->create([
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->deleteJson('/api/v1/products/' . $product->id);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Product deleted successfully'
                ]);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_products(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products');

        $response->assertStatus(401);
    }

    public function test_can_paginate_products(): void
    {
        Product::factory()->count(25)->create([
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?per_page=10&page=2');

        $response->assertStatus(200);
        $this->assertEquals(10, count($response->json('data.data')));
        $this->assertEquals(2, $response->json('data.current_page'));
        $this->assertEquals(25, $response->json('data.total'));
    }

    public function test_can_sort_products(): void
    {
        Product::factory()->create([
            'product_name' => 'A Product',
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);
        
        Product::factory()->create([
            'product_name' => 'Z Product',
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->getJson('/api/v1/products?sort_by=product_name&sort_direction=asc');

        $response->assertStatus(200);
        $this->assertEquals('A Product', $response->json('data.data.0.product_name'));
        $this->assertEquals('Z Product', $response->json('data.data.1.product_name'));
    }
}
