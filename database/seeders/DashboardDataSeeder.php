<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Supplier;
use App\Models\Coupon;
use App\Models\Slideshow;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DashboardDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the admin user that was created in DatabaseSeeder
        $user = User::where('email', 'admin@example.com')->first();

        if (!$user) {
            $this->command->error('Admin user not found. Please check DatabaseSeeder.');
            return;
        }

        // Create one simple test product
        $product = Product::create([
            'product_name' => 'Test Product',
            'slug' => 'test-product',
            'sku' => 'SKU-TEST-001',
            'sale_price' => 29.99,
            'compare_price' => 39.99,
            'quantity' => 100,
            'short_description' => 'Test product description',
            'product_description' => 'Full test product description',
            'published' => true,
            'disable_out_of_stock' => false,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        $this->command->info('Simple test data seeded successfully!');
    }
}
