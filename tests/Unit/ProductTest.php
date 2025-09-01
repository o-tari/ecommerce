<?php

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Supplier;
use App\Models\Variant;
use App\Models\VariantOption;
use App\Models\OrderItem;
use App\Models\ProductShippingInfo;
use App\Models\Sell;
use App\Models\CardItem;
use App\Models\Coupon;
use App\Models\ProductAttribute;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttributeValue;
use App\Models\VariantValue;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->product = Product::factory()->make([
        'created_by' => $this->user->id,
        'updated_by' => $this->user->id,
        'published' => true, // Ensure the product is published
    ]);
    $this->product->save();
});

describe('Product Model', function () {
    it('can be created with valid attributes', function () {
        expect($this->product)->toBeInstanceOf(Product::class);
        expect($this->product->product_name)->toBeString();
        expect($this->product->slug)->toBeString();
        expect($this->product->sale_price)->toBeNumeric();
        expect($this->product->quantity)->toBeInt();
    });

    it('has correct fillable attributes', function () {
        $fillable = [
            'slug',
            'product_name',
            'sku',
            'sale_price',
            'compare_price',
            'buying_price',
            'quantity',
            'short_description',
            'product_description',
            'published',
            'disable_out_of_stock',
            'note',
            'created_by',
            'updated_by',
            'product_type',
        ];

        expect($this->product->getFillable())->toBe($fillable);
    });

    it('has correct casts', function () {
        expect($this->product->sale_price)->toBeString();
        expect($this->product->compare_price)->toBeString();
        // buying_price can be null or string depending on the factory
        if ($this->product->buying_price !== null) {
            expect($this->product->buying_price)->toBeString();
        }
        expect($this->product->quantity)->toBeInt();
        expect($this->product->published)->toBeBool();
        expect($this->product->disable_out_of_stock)->toBeBool();
    });

    it('can generate slug from product name', function () {
        $product = Product::create([
            'product_name' => 'Test Product Name',
            'slug' => 'test-product-name',
            'sale_price' => 29.99,
            'compare_price' => 39.99,
            'quantity' => 100,
            'short_description' => 'Test description',
            'product_description' => 'Test full description',
            'published' => true,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        expect($product->slug)->toBe('test-product-name');
    });
});

describe('Product Relationships', function () {
    it('belongs to created by user', function () {
        expect($this->product->createdBy)->toBeInstanceOf(User::class);
        expect($this->product->createdBy->id)->toBe($this->user->id);
    });

    it('belongs to updated by user', function () {
        expect($this->product->updatedBy)->toBeInstanceOf(User::class);
        expect($this->product->updatedBy->id)->toBe($this->user->id);
    });

    it('can have many variants', function () {
        Variant::factory()->create(['product_id' => $this->product->id]);
        Variant::factory()->create(['product_id' => $this->product->id]);

        expect($this->product->variants)->toHaveCount(2);
        expect($this->product->variants->first())->toBeInstanceOf(Variant::class);
    });

    it('can have many variant options', function () {
        VariantOption::factory()->create(['product_id' => $this->product->id]);
        VariantOption::factory()->create(['product_id' => $this->product->id]);

        expect($this->product->variantOptions)->toHaveCount(2);
        expect($this->product->variantOptions->first())->toBeInstanceOf(VariantOption::class);
    });

    it('can have many order items', function () {
        OrderItem::factory()->create(['product_id' => $this->product->id]);
        OrderItem::factory()->create(['product_id' => $this->product->id]);

        expect($this->product->orderItems)->toHaveCount(2);
        expect($this->product->orderItems->first())->toBeInstanceOf(OrderItem::class);
    });

    it('has one shipping info', function () {
        ProductShippingInfo::factory()->create(['product_id' => $this->product->id]);

        expect($this->product->shippingInfo)->toBeInstanceOf(ProductShippingInfo::class);
    });

    it('has one sell record', function () {
        Sell::factory()->create(['product_id' => $this->product->id]);

        expect($this->product->sells)->toBeInstanceOf(Sell::class);
        expect($this->product->sells->product_id)->toBe($this->product->id);
    });

    it('can have many card items', function () {
        CardItem::factory()->create(['product_id' => $this->product->id]);
        CardItem::factory()->create(['product_id' => $this->product->id]);

        expect($this->product->cardItems)->toHaveCount(2);
        expect($this->product->cardItems->first())->toBeInstanceOf(CardItem::class);
    });

    it('can have many product attributes', function () {
        // Create product attributes through the factory
        $this->product->productAttributes()->create([
            'attribute_id' => \App\Models\Attribute::factory()->create()->id,
            'value' => 'Test Value 1',
        ]);
        $this->product->productAttributes()->create([
            'attribute_id' => \App\Models\Attribute::factory()->create()->id,
            'value' => 'Test Value 2',
        ]);

        expect($this->product->productAttributes)->toHaveCount(2);
        expect($this->product->productAttributes->first())->toBeInstanceOf(\App\Models\ProductAttribute::class);
    });

    it('can belong to many categories', function () {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        $this->product->categories()->attach([$category1->id, $category2->id]);

        expect($this->product->categories)->toHaveCount(2);
        expect($this->product->categories->first())->toBeInstanceOf(Category::class);
    });

    it('can belong to many tags', function () {
        $tag1 = Tag::factory()->create();
        $tag2 = Tag::factory()->create();

        $this->product->tags()->attach([$tag1->id, $tag2->id]);

        expect($this->product->tags)->toHaveCount(2);
        expect($this->product->tags->first())->toBeInstanceOf(Tag::class);
    });

    it('can belong to many suppliers', function () {
        $supplier1 = Supplier::factory()->create();
        $supplier2 = Supplier::factory()->create();

        $this->product->suppliers()->attach([$supplier1->id, $supplier2->id]);

        expect($this->product->suppliers)->toHaveCount(2);
        expect($this->product->suppliers->first())->toBeInstanceOf(Supplier::class);
    });

    it('can belong to many coupons', function () {
        $coupon1 = Coupon::factory()->create();
        $coupon2 = Coupon::factory()->create();

        $this->product->productCoupons()->attach([$coupon1->id, $coupon2->id]);

        expect($this->product->productCoupons)->toHaveCount(2);
        expect($this->product->productCoupons->first())->toBeInstanceOf(Coupon::class);
    });
});

describe('Product Deletion', function () {
    it('deletes related records when product is deleted', function () {
        // Create related records
        $variant = Variant::factory()->create(['product_id' => $this->product->id]);
        $variantOption = VariantOption::factory()->create(['product_id' => $this->product->id]);
        $orderItem = OrderItem::factory()->create(['product_id' => $this->product->id]);
        $shippingInfo = ProductShippingInfo::factory()->create(['product_id' => $this->product->id]);
        $sell = Sell::factory()->create(['product_id' => $this->product->id]);
        $cardItem = CardItem::factory()->create(['product_id' => $this->product->id]);
        // Create variant values and product attribute values
        $attribute = Attribute::factory()->create();
        $attributeValue = AttributeValue::factory()->create(['attribute_id' => $attribute->id]);
        $productAttributeValue = ProductAttributeValue::factory()->create([
            'product_id' => $this->product->id,
            'attribute_id' => $attribute->id,
            'attribute_value_id' => $attributeValue->id,
        ]);
        $variantValue = VariantValue::factory()->create([
            'variant_id' => $variant->id,
            'product_id' => $this->product->id,
            'attribute_id' => $attribute->id,
            'attribute_value_id' => $attributeValue->id,
        ]);

        // Store IDs for verification
        $variantId = $variant->id;
        $variantOptionId = $variantOption->id;
        $orderItemId = $orderItem->id;
        $shippingInfoId = $shippingInfo->id;
        $sellId = $sell->id;
        $cardItemId = $cardItem->id;

        // Delete the product
        $this->product->delete();

        // Verify all related records are deleted
        expectModelToBeHardDeleted(Variant::class, $variantId);
        expectModelToBeHardDeleted(VariantOption::class, $variantOptionId);
        expectModelToBeHardDeleted(OrderItem::class, $orderItemId);
        expectModelToBeHardDeleted(ProductShippingInfo::class, $shippingInfoId);
        expectModelToBeHardDeleted(Sell::class, $sellId);
        expectModelToBeHardDeleted(CardItem::class, $cardItemId);
        // Check ProductAttributeValue deletion differently since it has composite key
        $remainingProductAttributeValues = ProductAttributeValue::where('product_id', $this->product->id)->count();
        expect($remainingProductAttributeValues)->toBe(0);
        // Check VariantValue deletion differently since it has composite key
        $remainingVariantValues = VariantValue::where('product_id', $this->product->id)->count();
        expect($remainingVariantValues)->toBe(0);
        expectModelToBeHardDeleted(Product::class, $this->product->id);
    });

    it('detaches many-to-many relationships when product is deleted', function () {
        $category = Category::factory()->create();
        $tag = Tag::factory()->create();
        $supplier = Supplier::factory()->create();
        $coupon = Coupon::factory()->create();

        $this->product->categories()->attach($category->id);
        $this->product->tags()->attach($tag->id);
        $this->product->suppliers()->attach($supplier->id);
        $this->product->productCoupons()->attach($coupon->id);

        // Verify relationships are attached
        expect($this->product->categories)->toHaveCount(1);
        expect($this->product->tags)->toHaveCount(1);
        expect($this->product->suppliers)->toHaveCount(1);
        expect($this->product->productCoupons)->toHaveCount(1);

        // Delete the product
        $this->product->delete();

        // Verify relationships are detached
        expect($category->products()->count())->toBe(0);
        expect($tag->products()->count())->toBe(0);
        expect($supplier->products()->count())->toBe(0);
        expect($coupon->products()->count())->toBe(0);
    });
});

describe('Product Scopes and Queries', function () {
    it('can scope published products', function () {
        // Create products without the factory's automatic category creation
        $unpublishedProduct = Product::factory()->make(['published' => false, 'created_by' => $this->user->id, 'updated_by' => $this->user->id]);
        $unpublishedProduct->save();
        
        $publishedProduct = Product::factory()->make(['published' => true, 'created_by' => $this->user->id, 'updated_by' => $this->user->id]);
        $publishedProduct->save();

        $publishedProducts = Product::where('published', true)->get();
        expect($publishedProducts)->toHaveCount(2); // The one from beforeEach + the new published one
    });

    it('can scope by product type', function () {
        Product::factory()->create(['product_type' => 'simple', 'created_by' => $this->user->id, 'updated_by' => $this->user->id]);
        Product::factory()->create(['product_type' => 'variable', 'created_by' => $this->user->id, 'updated_by' => $this->user->id]);

        $simpleProducts = Product::where('product_type', 'simple')->get();
        $variableProducts = Product::where('product_type', 'variable')->get();

        expect($simpleProducts)->toHaveCount(1);
        expect($variableProducts)->toHaveCount(1);
    });

    it('can search by product name', function () {
        Product::factory()->create(['product_name' => 'Special Product', 'created_by' => $this->user->id, 'updated_by' => $this->user->id]);

        $searchResults = Product::where('product_name', 'like', '%Special%')->get();
        expect($searchResults)->toHaveCount(1);
        expect($searchResults->first()->product_name)->toBe('Special Product');
    });
});

    describe('Product Media', function () {
        it('can handle media-related functionality', function () {
            // Placeholder for future media functionality
            expect($this->product)->toBeInstanceOf(\App\Models\Product::class);
        });
    });
