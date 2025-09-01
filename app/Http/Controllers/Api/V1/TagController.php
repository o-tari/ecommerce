<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\TagRequest;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TagController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Tag::with(['products', 'createdBy', 'updatedBy']);

        // Apply filters
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $tags = $query->paginate($perPage);

        return $this->successResponse($tags, 'Tags retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Set created_by and updated_by
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $tag = Tag::create($data);

        $tag->load(['createdBy', 'updatedBy']);

        return $this->successResponse($tag, 'Tag created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag): JsonResponse
    {
        $tag->load(['products', 'createdBy', 'updatedBy']);

        return $this->successResponse($tag, 'Tag retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, Tag $tag): JsonResponse
    {
        $data = $request->validated();
        
        // Set updated_by
        $data['updated_by'] = auth()->id();

        $tag->update($data);

        $tag->load(['createdBy', 'updatedBy']);

        return $this->successResponse($tag, 'Tag updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag): JsonResponse
    {
        // Check if tag has products
        if ($tag->products()->exists()) {
            return $this->errorResponse('Cannot delete tag with products', Response::HTTP_CONFLICT);
        }

        $tag->delete();

        return $this->successResponse(null, 'Tag deleted successfully');
    }
}
