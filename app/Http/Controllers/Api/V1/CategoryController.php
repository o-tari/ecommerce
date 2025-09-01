<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Category::with(['parent', 'children', 'creator', 'updater']);

        // Apply filters
        if ($request->has('active')) {
            $query->where('active', $request->boolean('active'));
        }

        if ($request->has('parent_id')) {
            if ($request->parent_id === 'null') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $request->parent_id);
            }
        }

        if ($request->has('search')) {
            $query->where('category_name', 'like', '%' . $request->search . '%');
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'category_name');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $categories = $query->paginate($perPage);

        return $this->successResponse($categories, 'Categories retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Set created_by and updated_by
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $category = Category::create($data);

        $category->load(['parent', 'children', 'creator', 'updater']);

        return $this->successResponse($category, 'Category created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): JsonResponse
    {
        $category->load(['parent', 'children', 'products', 'creator', 'updater']);

        return $this->successResponse($category, 'Category retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $data = $request->validated();
        
        // Set updated_by
        $data['updated_by'] = auth()->id();

        $category->update($data);

        $category->load(['parent', 'children', 'creator', 'updater']);

        return $this->successResponse($category, 'Category updated successfully');
    }

    /**
     * Remove the specified resource in storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        // Check if category has children
        if ($category->children()->exists()) {
            return $this->errorResponse('Cannot delete category with subcategories', Response::HTTP_CONFLICT);
        }

        // Check if category has products
        if ($category->products()->exists()) {
            return $this->errorResponse('Cannot delete category with products', Response::HTTP_CONFLICT);
        }

        $category->delete();

        return $this->successResponse(null, 'Category deleted successfully');
    }
}
