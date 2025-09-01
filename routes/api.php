<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\TagController;
use App\Http\Controllers\Api\V1\SupplierController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\AttributeController;
use App\Http\Controllers\Api\V1\VariantController;
use App\Http\Controllers\Api\V1\CouponController;
use App\Http\Controllers\Api\V1\SlideshowController;
use App\Http\Controllers\Api\V1\CardController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\ShippingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::prefix('v1')->group(function () {
    // Authentication routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        // Auth
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/revoke-token', [AuthController::class, 'revokeToken']);
        Route::get('/user', [AuthController::class, 'user']);
        
        // Products
        Route::apiResource('products', ProductController::class);
        
        // Categories
        Route::apiResource('categories', CategoryController::class);
        
        // Tags
        Route::apiResource('tags', TagController::class);
        
        // Suppliers
        Route::apiResource('suppliers', SupplierController::class);
        
        // Orders
        Route::apiResource('orders', OrderController::class);
        
        // Customers
        Route::apiResource('customers', CustomerController::class);
        
        // Users
        Route::apiResource('users', UserController::class);
        
        // Attributes
        Route::apiResource('attributes', AttributeController::class);
        
        // Variants
        Route::apiResource('variants', VariantController::class);
        
        // Coupons
        Route::apiResource('coupons', CouponController::class);
        
        // Slideshows
        Route::apiResource('slideshows', SlideshowController::class);
        
        // Cards
        Route::apiResource('cards', CardController::class);
        
        // Countries
        Route::apiResource('countries', CountryController::class);
        
        // Shipping
        Route::apiResource('shipping-zones', ShippingController::class);
        Route::apiResource('shipping-rates', ShippingController::class);
    });
});
