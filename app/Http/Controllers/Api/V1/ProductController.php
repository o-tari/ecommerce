<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::with(['categories', 'tags', 'suppliers', 'createdBy', 'updatedBy']);

        // Apply filters
        if ($request->has('published')) {
            $query->where('published', $request->boolean('published'));
        }

        if ($request->has('product_type')) {
            $query->where('product_type', $request->product_type);
        }

        if ($request->has('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $products = $query->paginate($perPage);

        return $this->successResponse($products, 'Products retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Set created_by and updated_by
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $product = Product::create($data);

        // Handle relationships
        if ($request->has('categories')) {
            $product->categories()->attach($request->categories);
        }

        if ($request->has('tags')) {
            $product->tags()->attach($request->tags);
        }

        if ($request->has('suppliers')) {
            $product->suppliers()->attach($request->suppliers);
        }

        $product->load(['categories', 'tags', 'suppliers', 'createdBy', 'updatedBy']);

        return $this->successResponse($product, 'Product created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {
        $product->load(['categories', 'tags', 'suppliers', 'createdBy', 'updatedBy', 'variants', 'productAttributes']);

        return $this->successResponse($product, 'Product retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();
        
        // Set updated_by
        $data['updated_by'] = auth()->id();

        $product->update($data);

        // Handle relationships
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        if ($request->has('tags')) {
            $product->tags()->sync($request->tags);
        }

        if ($request->has('suppliers')) {
            $product->suppliers()->sync($request->suppliers);
        }

        $product->load(['categories', 'tags', 'suppliers', 'createdBy', 'updatedBy']);

        return $this->successResponse($product, 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return $this->successResponse(null, 'Product deleted successfully');
    }
}
