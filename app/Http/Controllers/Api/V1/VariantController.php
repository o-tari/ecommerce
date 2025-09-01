<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\VariantRequest;
use App\Models\Variant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VariantController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Variant::with(['product', 'variantValues', 'createdBy', 'updatedBy']);

        // Apply filters
        if ($request->has('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->has('search')) {
            $query->where('sku', 'like', '%' . $request->search . '%');
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $variants = $query->paginate($perPage);

        return $this->successResponse($variants, 'Variants retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VariantRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Set created_by and updated_by
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $variant = Variant::create($data);

        $variant->load(['product', 'variantValues', 'createdBy', 'updatedBy']);

        return $this->successResponse($variant, 'Variant created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Variant $variant): JsonResponse
    {
        $variant->load(['product', 'variantValues.attribute', 'createdBy', 'updatedBy']);

        return $this->successResponse($variant, 'Variant retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VariantRequest $request, Variant $variant): JsonResponse
    {
        $data = $request->validated();
        
        // Set updated_by
        $data['updated_by'] = auth()->id();

        $variant->update($data);

        $variant->load(['product', 'variantValues', 'createdBy', 'updatedBy']);

        return $this->successResponse($variant, 'Variant updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Variant $variant): JsonResponse
    {
        $variant->delete();

        return $this->successResponse(null, 'Variant deleted successfully');
    }
}
