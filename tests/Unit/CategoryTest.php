<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->category = Category::factory()->create([
        'active' => true,
        'created_by' => $this->user->id,
        'updated_by' => $this->user->id,
    ]);
});

describe('Category Model', function () {
    it('can be created with valid attributes', function () {
        expect($this->category)->toBeInstanceOf(Category::class);
        expect($this->category->category_name)->toBeString();
        expect($this->category->category_description)->toBeString();
    });

    it('has correct fillable attributes', function () {
        $fillable = [
            'category_name',
            'category_description',
            'placeholder',
            'active',
            'parent_id',
            'created_by',
            'updated_by',
        ];

        expect($this->category->getFillable())->toBe($fillable);
    });

    it('has correct casts', function () {
        expect($this->category->active)->toBeBool();
    });

    // Removed slug generation test as Category model doesn't have slug functionality
});

describe('Category Relationships', function () {
    it('belongs to created by user', function () {
        expect($this->category->creator)->toBeInstanceOf(User::class);
        expect($this->category->creator->id)->toBe($this->user->id);
    });

    it('belongs to updated by user', function () {
        expect($this->category->updater)->toBeInstanceOf(User::class);
        expect($this->category->updater->id)->toBe($this->user->id);
    });

    it('can have parent category', function () {
        $parentCategory = Category::factory()->create([
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $childCategory = Category::factory()->create([
            'parent_id' => $parentCategory->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        expect($childCategory->parent)->toBeInstanceOf(Category::class);
        expect($childCategory->parent->id)->toBe($parentCategory->id);
    });

    it('can have many child categories', function () {
        $child1 = Category::factory()->create([
            'parent_id' => $this->category->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);
        $child2 = Category::factory()->create([
            'parent_id' => $this->category->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        expect($this->category->children)->toHaveCount(2);
        expect($this->category->children->first())->toBeInstanceOf(Category::class);
    });

    it('can belong to many products', function () {
        $product1 = Product::factory()->create([
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);
        $product2 = Product::factory()->create([
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $this->category->products()->attach([$product1->id, $product2->id]);

        expect($this->category->products)->toHaveCount(2);
        expect($this->category->products->first())->toBeInstanceOf(Product::class);
    });
});

describe('Category Scopes and Queries', function () {
    it('can scope active categories', function () {
        Category::factory()->create(['active' => false, 'created_by' => $this->user->id, 'updated_by' => $this->user->id]);
        Category::factory()->create(['active' => true, 'created_by' => $this->user->id, 'updated_by' => $this->user->id]);

        $activeCategories = Category::where('active', true)->get();
        expect($activeCategories)->toHaveCount(2); // Including the one from beforeEach
    });

    it('can scope root categories', function () {
        $childCategory = Category::factory()->create([
            'parent_id' => $this->category->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $rootCategories = Category::whereNull('parent_id')->get();
        $childCategories = Category::whereNotNull('parent_id')->get();

        expect($rootCategories)->toHaveCount(1);
        expect($childCategories)->toHaveCount(1);
    });

    it('can search by category name', function () {
        Category::factory()->create(['category_name' => 'Special Category', 'created_by' => $this->user->id, 'updated_by' => $this->user->id]);

        $searchResults = Category::where('category_name', 'like', '%Special%')->get();
        expect($searchResults)->toHaveCount(1);
        expect($searchResults->first()->category_name)->toBe('Special Category');
    });
});

describe('Category Hierarchy', function () {
    it('can build category tree', function () {
        $parent = Category::factory()->create([
            'category_name' => 'Parent',
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $child1 = Category::factory()->create([
            'category_name' => 'Child 1',
            'parent_id' => $parent->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $child2 = Category::factory()->create([
            'category_name' => 'Child 2',
            'parent_id' => $parent->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $grandchild = Category::factory()->create([
            'category_name' => 'Grandchild',
            'parent_id' => $child1->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        expect($parent->children)->toHaveCount(2);
        expect($child1->children)->toHaveCount(1);
        expect($child2->children)->toHaveCount(0);
        expect($grandchild->parent->id)->toBe($child1->id);
    });
});

describe('Category Deletion', function () {
    it('can be deleted', function () {
        $categoryId = $this->category->id;
        $this->category->delete();

        expectModelToBeHardDeleted(Category::class, $categoryId);
    });

    it('detaches products when deleted', function () {
        // Create product without automatic category creation
        $product = Product::factory()->make([
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);
        $product->save();

        $this->category->products()->attach($product->id);
        expect($this->category->products)->toHaveCount(1);

        $this->category->delete();
        
        // Refresh the product to get updated relationship data
        $product->refresh();
        expect($product->categories()->count())->toBe(0);
    });
});
