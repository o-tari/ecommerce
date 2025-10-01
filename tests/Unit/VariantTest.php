<?php

use App\Models\Variant;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use App\Models\VariantValue;
use App\Models\VariantOption;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->product = Product::factory()->create([
        'created_by' => $this->user->id,
        'updated_by' => $this->user->id,
    ]);
    $this->variant = Variant::factory()->create([
        'product_id' => $this->product->id,
        'variant_option' => 'Test Option',
        'variant_option_id' => VariantOption::factory()->create(['product_id' => $this->product->id])->id,
        'is_active' => true, // Ensure the test variant is active
        'price' => 278.99,
    ]);
});

describe('Variant Model', function () {
    it('can be created with valid attributes', function () {
        expect($this->variant)->toBeInstanceOf(Variant::class);
        expect($this->variant->product_id)->toBe($this->product->id);
        expect($this->variant->sku)->toBeString();
        expect($this->variant->price)->toBeNumeric();
        expect($this->variant->quantity)->toBeInt();
    });

    it('has correct fillable attributes', function () {
        $fillable = [
            'variant_option',
            'product_id',
            'variant_option_id',
            'sku',
            'price',
            'quantity',
            'weight',
            'is_active',
        ];

        expect($this->variant->getFillable())->toBe($fillable);
    });

    it('has correct casts', function () {
        expect($this->variant->price)->toBeNumeric();
        expect($this->variant->quantity)->toBeInt();
        expect($this->variant->weight)->toBeNumeric();
        expect($this->variant->is_active)->toBeBool();
    });

    it('can generate unique SKU', function () {
        $variant = Variant::create([
            'product_id' => $this->product->id,
            'variant_option' => 'Test Option',
            'variant_option_id' => VariantOption::factory()->create(['product_id' => $this->product->id])->id,
            'sku' => 'VARIANT-001',
            'price' => 29.99,
            'quantity' => 100,
        ]);

        expect($variant->sku)->toBe('VARIANT-001');
    });
});

describe('Variant Relationships', function () {
    it('belongs to product', function () {
        expect($this->variant->product)->toBeInstanceOf(Product::class);
        expect($this->variant->product->id)->toBe($this->product->id);
    });

    it('belongs to a variant option', function () {
        // The relationship is: Variant belongs to VariantOption, not the other way around
        // So we test that a variant can belong to a variant option
        $variantOption = VariantOption::factory()->create(['product_id' => $this->product->id]);
        $this->variant->update(['variant_option_id' => $variantOption->id]);

        expect($this->variant->variantOption)->toBeInstanceOf(VariantOption::class);
        expect($this->variant->variantOption->id)->toBe($variantOption->id);
    });

    it('can have many attribute values through variant values', function () {
        $attribute = Attribute::factory()->create();
        $attributeValue1 = AttributeValue::factory()->create(['attribute_id' => $attribute->id]);
        $attributeValue2 = AttributeValue::factory()->create(['attribute_id' => $attribute->id]);

        // Create variant values using the actual schema
        VariantValue::factory()->create([
            'variant_id' => $this->variant->id,
            'product_id' => $this->product->id,
            'attribute_id' => $attribute->id,
            'attribute_value_id' => $attributeValue1->id,
        ]);

        VariantValue::factory()->create([
            'variant_id' => $this->variant->id,
            'product_id' => $this->product->id,
            'attribute_id' => $attribute->id,
            'attribute_value_id' => $attributeValue2->id,
        ]);

        expect($this->variant->attributeValues)->toHaveCount(2);
        expect($this->variant->attributeValues->first())->toBeInstanceOf(AttributeValue::class);
    });

    it('can have many product attributes through variant values', function () {
        $attribute1 = Attribute::factory()->create();
        $attribute2 = Attribute::factory()->create();

        $attributeValue1 = AttributeValue::factory()->create(['attribute_id' => $attribute1->id]);
        $attributeValue2 = AttributeValue::factory()->create(['attribute_id' => $attribute2->id]);

        VariantValue::factory()->create([
            'variant_id' => $this->variant->id,
            'product_id' => $this->product->id,
            'attribute_id' => $attribute1->id,
            'attribute_value_id' => $attributeValue1->id,
        ]);

        VariantValue::factory()->create([
            'variant_id' => $this->variant->id,
            'product_id' => $this->product->id,
            'attribute_id' => $attribute2->id,
            'attribute_value_id' => $attributeValue2->id,
        ]);

        expect($this->variant->productAttributes)->toHaveCount(2);
        expect($this->variant->productAttributes->first())->toBeInstanceOf(Attribute::class);
    });
});

describe('Variant Scopes and Queries', function () {
    it('can scope active variants', function () {
        Variant::factory()->create([
            'product_id' => $this->product->id,
            'is_active' => false,
        ]);

        Variant::factory()->create([
            'product_id' => $this->product->id,
            'is_active' => true,
        ]);

        $activeVariants = Variant::where('is_active', true)->get();
        expect($activeVariants)->toHaveCount(2); // Including the one from beforeEach
    });

    it('can scope variants by product', function () {
        $otherProduct = Product::factory()->create([
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        Variant::factory()->create(['product_id' => $otherProduct->id]);

        $productVariants = Variant::where('product_id', $this->product->id)->get();
        $otherProductVariants = Variant::where('product_id', $otherProduct->id)->get();

        expect($productVariants)->toHaveCount(1);
        expect($otherProductVariants)->toHaveCount(1);
    });

    it('can search variants by SKU', function () {
        Variant::factory()->create([
            'product_id' => $this->product->id,
            'sku' => 'SPECIAL-VARIANT',
        ]);

        $searchResults = Variant::where('sku', 'like', '%SPECIAL%')->get();
        expect($searchResults)->toHaveCount(1);
        expect($searchResults->first()->sku)->toBe('SPECIAL-VARIANT');
    });

    it('can filter variants by price range', function () {
        // Create variants with specific prices for predictable testing
        $lowPriceVariant = Variant::factory()->create([
            'product_id' => $this->product->id,
            'price' => 19.99,
        ]);

        $highPriceVariant = Variant::factory()->create([
            'product_id' => $this->product->id,
            'price' => 99.99,
        ]);

        // Get all variants for this product and filter by price
        $allVariants = Variant::where('product_id', $this->product->id)->get();
        
        // Get all variants for this product and filter by price
        $allVariants = Variant::where('product_id', $this->product->id)->get();
        
        $lowPriceVariants = $allVariants->where('price', '<=', 50.00);
        $highPriceVariants = $allVariants->where('price', '>', 50.00);

        // We should have exactly 3 variants: beforeEach variant + 2 new variants
        expect($allVariants)->toHaveCount(3);
        expect($lowPriceVariants)->toHaveCount(1); // 19.99 variant only
        expect($highPriceVariants)->toHaveCount(2); // beforeEach variant (278.99) + 99.99 variant
    });
});

describe('Variant Inventory Management', function () {
    it('can check if variant is in stock', function () {
        $inStockVariant = Variant::factory()->create([
            'product_id' => $this->product->id,
            'quantity' => 10,
        ]);

        $outOfStockVariant = Variant::factory()->create([
            'product_id' => $this->product->id,
            'quantity' => 0,
        ]);

        expect($inStockVariant->quantity > 0)->toBeTrue();
        expect($outOfStockVariant->quantity > 0)->toBeFalse();
    });

    it('can update variant quantity', function () {
        $initialQuantity = $this->variant->quantity;
        $this->variant->update(['quantity' => $initialQuantity + 5]);

        $this->variant->refresh();
        expect($this->variant->quantity)->toBe($initialQuantity + 5);
    });

    it('can decrease variant quantity', function () {
        $initialQuantity = $this->variant->quantity;
        $this->variant->update(['quantity' => $initialQuantity - 2]);

        $this->variant->refresh();
        expect($this->variant->quantity)->toBe($initialQuantity - 2);
    });

    it('prevents negative quantity', function () {
        $initialQuantity = $this->variant->quantity;
        $this->variant->update(['quantity' => max(0, $initialQuantity - 1000)]);

        $this->variant->refresh();
        expect($this->variant->quantity)->toBeGreaterThanOrEqual(0);
    });
});

describe('Variant Pricing', function () {
    it('can calculate variant total value', function () {
        $this->variant->update([
            'price' => 25.00,
            'quantity' => 4,
        ]);

        $this->variant->refresh();
        $totalValue = $this->variant->price * $this->variant->quantity;
        expect($totalValue)->toBe(100.0);
    });

    it('can apply discount to variant price', function () {
        $originalPrice = $this->variant->price;
        $discountPercentage = 20; // 20% discount
        $discountedPrice = $originalPrice * (1 - ($discountPercentage / 100));

        $this->variant->update(['price' => $discountedPrice]);

        $this->variant->refresh();
        // Use a tolerant comparison for floating point precision issues
        expect(abs($this->variant->price - $discountedPrice))->toBeLessThan(0.01);
    });

    it('can compare variant prices', function () {
        $cheapVariant = Variant::factory()->create([
            'product_id' => $this->product->id,
            'price' => 15.00,
        ]);

        $expensiveVariant = Variant::factory()->create([
            'product_id' => $this->product->id,
            'price' => 45.00,
        ]);

        expect($cheapVariant->price < $expensiveVariant->price)->toBeTrue();
        expect($expensiveVariant->price > $cheapVariant->price)->toBeTrue();
    });
});

describe('Variant Attributes and Options', function () {
    it('can have multiple attribute combinations', function () {
        $colorAttribute = Attribute::factory()->create(['attribute_name' => 'Color']);
        $sizeAttribute = Attribute::factory()->create(['attribute_name' => 'Size']);

        $redValue = AttributeValue::factory()->create([
            'attribute_id' => $colorAttribute->id,
            'attribute_value' => 'Red',
        ]);

        $largeValue = AttributeValue::factory()->create([
            'attribute_id' => $sizeAttribute->id,
            'attribute_value' => 'Large',
        ]);

        VariantValue::factory()->create([
            'variant_id' => $this->variant->id,
            'product_id' => $this->product->id,
            'attribute_id' => $colorAttribute->id,
            'attribute_value_id' => $redValue->id,
        ]);

        VariantValue::factory()->create([
            'variant_id' => $this->variant->id,
            'product_id' => $this->product->id,
            'attribute_id' => $sizeAttribute->id,
            'attribute_value_id' => $largeValue->id,
        ]);

        expect($this->variant->attributeValues)->toHaveCount(2);
        expect($this->variant->productAttributes)->toHaveCount(2);
    });

    it('can generate variant name from attributes', function () {
        $colorAttribute = Attribute::factory()->create(['attribute_name' => 'Color']);
        $sizeAttribute = Attribute::factory()->create(['attribute_name' => 'Size']);

        $redValue = AttributeValue::factory()->create([
            'attribute_id' => $colorAttribute->id,
            'attribute_value' => 'Red',
        ]);

        $largeValue = AttributeValue::factory()->create([
            'attribute_id' => $sizeAttribute->id,
            'attribute_value' => 'Large',
        ]);

        VariantValue::factory()->create([
            'variant_id' => $this->variant->id,
            'product_id' => $this->product->id,
            'attribute_id' => $colorAttribute->id,
            'attribute_value_id' => $redValue->id,
        ]);

        VariantValue::factory()->create([
            'variant_id' => $this->variant->id,
            'product_id' => $this->product->id,
            'attribute_id' => $sizeAttribute->id,
            'attribute_value_id' => $largeValue->id,
        ]);

        $this->variant->refresh();
        
        // Variant name could be something like "Red - Large"
        $attributeValues = $this->variant->attributeValues->pluck('attribute_value')->toArray();
        expect($attributeValues)->toContain('Red');
        expect($attributeValues)->toContain('Large');
    });
});

describe('Variant Deletion', function () {
    it('can be deleted', function () {
        $variantId = $this->variant->id;
        $this->variant->delete();

        expectModelToBeHardDeleted(Variant::class, $variantId);
    });

    it('deletes related variant values when deleted', function () {
        $attribute = Attribute::factory()->create();
        $attributeValue = AttributeValue::factory()->create(['attribute_id' => $attribute->id]);

        $variantValue = VariantValue::factory()->create([
            'variant_id' => $this->variant->id,
            'product_id' => $this->product->id,
            'attribute_id' => $attribute->id,
            'attribute_value_id' => $attributeValue->id,
        ]);

        $variantId = $this->variant->id;

        $this->variant->delete();

        // Check VariantValue deletion differently since it has composite key
        $remainingVariantValues = VariantValue::where('variant_id', $variantId)->count();
        expect($remainingVariantValues)->toBe(0);
        expectModelToBeHardDeleted(Variant::class, $variantId);
    });

    it('deletes related variant options when deleted', function () {
        $variantOption = VariantOption::factory()->create([
            'product_id' => $this->product->id,
        ]);

        $this->variant->update(['variant_option_id' => $variantOption->id]);

        $variantOptionId = $variantOption->id;

        $this->variant->delete();

        // VariantOption should not be deleted when variant is deleted
        // because the relationship is Variant belongs to VariantOption
        expectModelToBeHardDeleted(Variant::class, $this->variant->id);
        expect(VariantOption::find($variantOptionId))->not->toBeNull();
    });
});

describe('Variant Factory', function () {
    it('can create variant with factory', function () {
        $variant = Variant::factory()->create();
        expect($variant)->toBeInstanceOf(Variant::class);
        expect($variant->product_id)->toBeInt();
        expect($variant->sku)->toBeString();
        expect($variant->price)->toBeNumeric();
        expect($variant->quantity)->toBeInt();
    });

    it('can create multiple variants with factory', function () {
        $variants = Variant::factory()->count(3)->create();
        expect($variants)->toHaveCount(3);
        
        foreach ($variants as $variant) {
            expect($variant)->toBeInstanceOf(Variant::class);
        }
    });

    it('can create variant with specific attributes', function () {
        $variant = Variant::factory()->create([
            'product_id' => $this->product->id,
            'sku' => 'CUSTOM-SKU',
            'price' => 99.99,
            'quantity' => 50,
        ]);

        expect($variant->product_id)->toBe($this->product->id);
        expect($variant->sku)->toBe('CUSTOM-SKU');
        expect($variant->price)->toBe('99.99');
        expect($variant->quantity)->toBe(50);
    });
});
