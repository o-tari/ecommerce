<?php

namespace Tests\Feature\Api\V1;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryApiTest extends BaseApiTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withAuth();
    }

    public function test_can_get_categories_list()
    {
        // Create some test categories
        Category::factory()->count(3)->create();

        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/v1/categories');

        $response->assertStatus(200);
        $this->assertEquals(3, $response->json('data.total'));
    }

    public function test_can_get_categories_with_pagination()
    {
        // Create more categories than default per_page
        Category::factory()->count(20)->create();

        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/v1/categories?per_page=5');

        $response->assertStatus(200);
        $this->assertEquals(20, $response->json('data.total'));
        $this->assertEquals(5, $response->json('data.per_page'));
        $this->assertCount(5, $response->json('data.data'));
    }

    public function test_can_sort_categories()
    {
        // Create categories with specific names for sorting
        Category::factory()->create(['category_name' => 'Zebra']);
        Category::factory()->create(['category_name' => 'Alpha']);
        Category::factory()->create(['category_name' => 'Beta']);

        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/v1/categories?sort_by=category_name&sort_direction=asc');

        $response->assertStatus(200);
        $data = $response->json('data.data');
        $this->assertEquals('Alpha', $data[0]['category_name']);
        $this->assertEquals('Beta', $data[1]['category_name']);
        $this->assertEquals('Zebra', $data[2]['category_name']);
    }

    public function test_can_filter_categories_by_active_status()
    {
        Category::factory()->create(['active' => true]);
        Category::factory()->create(['active' => false]);

        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/v1/categories?active=true');

        $response->assertStatus(200);
        $this->assertEquals(1, $response->json('data.total'));
        $this->assertTrue($response->json('data.data.0.active'));
    }

    public function test_can_filter_root_categories()
    {
        // Create a parent category
        $parentCategory = Category::factory()->create();
        
        // Create a child category
        Category::factory()->create(['parent_id' => $parentCategory->id]);

        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/v1/categories?parent_id=null');

        $response->assertStatus(200);
        $this->assertEquals(1, $response->json('data.total'));
        $this->assertNull($response->json('data.data.0.parent_id'));
    }

    public function test_can_search_categories()
    {
        Category::factory()->create(['category_name' => 'Special Category']);
        Category::factory()->create(['category_name' => 'Regular Category']);

        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/v1/categories?search=Special');

        $response->assertStatus(200);
        $this->assertEquals(1, $response->json('data.total'));
        $this->assertStringContainsString('Special', $response->json('data.data.0.category_name'));
    }

    public function test_can_get_single_category()
    {
        $category = Category::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/v1/categories/' . $category->id);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'category_name',
                        'category_description',
                        'placeholder',
                        'active',
                        'parent_id',
                        'created_by',
                        'updated_by',
                        'created_at',
                        'updated_at',
                        'parent',
                        'children',
                        'creator',
                        'updater',
                        'products'
                    ]
                ])
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'id' => $category->id,
                        'category_name' => $category->category_name,
                    ]
                ]);
    }

    public function test_can_create_category()
    {
        $categoryData = [
            'category_name' => 'Test Category',
            'category_description' => 'Test description',
            'placeholder' => 'Test placeholder',
            'active' => true,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/v1/categories', $categoryData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'category_name',
                        'category_description',
                        'placeholder',
                        'active',
                        'created_by',
                        'updated_by',
                        'created_at',
                        'updated_at'
                    ]
                ])
                ->assertJson([
                    'success' => true,
                    'message' => 'Category created successfully',
                    'data' => [
                        'category_name' => 'Test Category',
                        'category_description' => 'Test description',
                        'placeholder' => 'Test placeholder',
                        'active' => true,
                    ]
                ]);

        $this->assertDatabaseHas('categories', [
            'category_name' => 'Test Category',
            'category_description' => 'Test description',
            'placeholder' => 'Test placeholder',
            'active' => true,
        ]);
    }

    public function test_can_create_category_with_parent()
    {
        $parentCategory = Category::factory()->create();

        $categoryData = [
            'category_name' => 'Child Category',
            'category_description' => 'Child description',
            'placeholder' => 'Child placeholder',
            'active' => true,
            'parent_id' => $parentCategory->id,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/v1/categories', $categoryData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('categories', [
            'category_name' => 'Child Category',
            'parent_id' => $parentCategory->id,
        ]);
    }

    public function test_cannot_create_category_with_existing_name()
    {
        Category::factory()->create(['category_name' => 'Existing Category']);

        $categoryData = [
            'category_name' => 'Existing Category',
            'category_description' => 'Test description',
            'placeholder' => 'Test placeholder',
            'active' => true,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/v1/categories', $categoryData);

        $response->assertStatus(422);
    }

    public function test_can_update_category()
    {
        $category = Category::factory()->create();

        $updateData = [
            'category_name' => 'Updated Category Name',
            'category_description' => 'Updated description',
            'placeholder' => 'Updated placeholder',
            'active' => false,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->putJson('/api/v1/categories/' . $category->id, $updateData);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Category updated successfully',
                    'data' => [
                        'category_name' => 'Updated Category Name',
                        'category_description' => 'Updated description',
                        'placeholder' => 'Updated placeholder',
                        'active' => false,
                    ]
                ]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'category_name' => 'Updated Category Name',
            'category_description' => 'Updated description',
            'placeholder' => 'Updated placeholder',
            'active' => false,
        ]);
    }

    public function test_can_update_category_parent()
    {
        $category = Category::factory()->create();
        $newParent = Category::factory()->create();

        $updateData = [
            'category_name' => $category->category_name, // Keep existing name
            'parent_id' => $newParent->id,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->putJson('/api/v1/categories/' . $category->id, $updateData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'parent_id' => $newParent->id,
        ]);
    }

    public function test_can_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->withHeaders($this->authHeaders())
            ->deleteJson('/api/v1/categories/' . $category->id);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Category deleted successfully'
                ]);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_cannot_delete_category_with_children()
    {
        $parentCategory = Category::factory()->create();
        Category::factory()->create(['parent_id' => $parentCategory->id]);

        $response = $this->withHeaders($this->authHeaders())
            ->deleteJson('/api/v1/categories/' . $parentCategory->id);

        $response->assertStatus(409)
                ->assertJson([
                    'success' => false,
                    'message' => 'Cannot delete category with subcategories'
                ]);

        $this->assertDatabaseHas('categories', ['id' => $parentCategory->id]);
    }

    public function test_cannot_delete_category_with_products()
    {
        $category = Category::factory()->create();
        
        // Create a product and associate it with the category
        $product = \App\Models\Product::factory()->create();
        $category->products()->attach($product->id);

        $response = $this->withHeaders($this->authHeaders())
            ->deleteJson('/api/v1/categories/' . $category->id);

        $response->assertStatus(409)
                ->assertJson([
                    'success' => false,
                    'message' => 'Cannot delete category with products'
                ]);

        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }
}
