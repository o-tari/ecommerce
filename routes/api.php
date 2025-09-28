<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\TagController;
use App\Http\Controllers\Api\V1\SupplierController;
use App\Http\Controllers\Api\V1\OrderController;
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
    
    // Public product routes (no authentication required)
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    
    // Public category routes (no authentication required)
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);
    
    // Public tag routes (no authentication required)
    Route::get('/tags', [TagController::class, 'index']);
    Route::get('/tags/{tag}', [TagController::class, 'show']);
    
    // Public slideshow routes (no authentication required)
    Route::get('/slideshows', [SlideshowController::class, 'index']);
    Route::get('/slideshows/{slideshow}', [SlideshowController::class, 'show']);
    
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        // Auth
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/revoke-token', [AuthController::class, 'revokeToken']);
        Route::get('/user', [AuthController::class, 'user']);
        
        // Protected product routes (authentication required)
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);
        
        // Protected category routes (authentication required)
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
        
        // Protected tag routes (authentication required)
        Route::post('/tags', [TagController::class, 'store']);
        Route::put('/tags/{tag}', [TagController::class, 'update']);
        Route::delete('/tags/{tag}', [TagController::class, 'destroy']);
        
        // Suppliers
        Route::apiResource('suppliers', SupplierController::class);
        
        // Orders
        Route::apiResource('orders', OrderController::class);
        
        // Users
        Route::apiResource('users', UserController::class);
        
        // Attributes
        Route::apiResource('attributes', AttributeController::class);
        
        // Variants
        Route::apiResource('variants', VariantController::class);
        
        // Coupons
        Route::apiResource('coupons', CouponController::class);
        
        // Protected slideshow routes (authentication required)
        Route::post('/slideshows', [SlideshowController::class, 'store']);
        Route::put('/slideshows/{slideshow}', [SlideshowController::class, 'update']);
        Route::delete('/slideshows/{slideshow}', [SlideshowController::class, 'destroy']);
        
        // Cards
        Route::apiResource('cards', CardController::class);
        
        // Countries
        Route::apiResource('countries', CountryController::class);
        
        // Shipping
        Route::apiResource('shipping-zones', ShippingController::class);
        Route::apiResource('shipping-rates', ShippingController::class);
    });
});
