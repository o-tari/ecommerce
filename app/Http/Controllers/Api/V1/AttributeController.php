<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\AttributeRequest;
use App\Models\Attribute;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AttributeController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Attribute::with(['attributeValues', 'createdBy', 'updatedBy']);

        // Apply filters
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('is_required')) {
            $query->where('is_required', $request->boolean('is_required'));
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $attributes = $query->paginate($perPage);

        return $this->successResponse($attributes, 'Attributes retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttributeRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Set created_by and updated_by
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $attribute = Attribute::create($data);

        $attribute->load(['createdBy', 'updatedBy']);

        return $this->successResponse($attribute, 'Attribute created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attribute $attribute): JsonResponse
    {
        $attribute->load(['attributeValues', 'products', 'createdBy', 'updatedBy']);

        return $this->successResponse($attribute, 'Attribute retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttributeRequest $request, Attribute $attribute): JsonResponse
    {
        $data = $request->validated();
        
        // Set updated_by
        $data['updated_by'] = auth()->id();

        $attribute->update($data);

        $attribute->load(['createdBy', 'updatedBy']);

        return $this->successResponse($attribute, 'Attribute updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute): JsonResponse
    {
        // Check if attribute has products
        if ($attribute->products()->exists()) {
            return $this->errorResponse('Cannot delete attribute with products', Response::HTTP_CONFLICT);
        }

        $attribute->delete();

        return $this->successResponse(null, 'Attribute deleted successfully');
    }
}
