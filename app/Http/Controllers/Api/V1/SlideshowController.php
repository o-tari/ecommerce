<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\SlideshowRequest;
use App\Models\Slideshow;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SlideshowController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Slideshow::with(['createdBy', 'updatedBy']);

        // Apply filters
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'sort_order');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $slideshows = $query->paginate($perPage);

        return $this->successResponse($slideshows, 'Slideshows retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SlideshowRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Set created_by and updated_by
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $slideshow = Slideshow::create($data);

        $slideshow->load(['createdBy', 'updatedBy']);

        return $this->successResponse($slideshow, 'Slideshow created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Slideshow $slideshow): JsonResponse
    {
        $slideshow->load(['createdBy', 'updatedBy']);

        return $this->successResponse($slideshow, 'Slideshow retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SlideshowRequest $request, Slideshow $slideshow): JsonResponse
    {
        $data = $request->validated();
        
        // Set updated_by
        $data['updated_by'] = auth()->id();

        $slideshow->update($data);

        $slideshow->load(['createdBy', 'updatedBy']);

        return $this->successResponse($slideshow, 'Slideshow updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slideshow $slideshow): JsonResponse
    {
        $slideshow->delete();

        return $this->successResponse(null, 'Slideshow deleted successfully');
    }
}
