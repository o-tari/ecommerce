<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SupplierController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Supplier::with(['products', 'createdBy', 'updatedBy']);

        // Apply filters
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('contact_person', 'like', '%' . $request->search . '%');
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $suppliers = $query->paginate($perPage);

        return $this->successResponse($suppliers, 'Suppliers retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Set created_by and updated_by
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $supplier = Supplier::create($data);

        $supplier->load(['createdBy', 'updatedBy']);

        return $this->successResponse($supplier, 'Supplier created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier): JsonResponse
    {
        $supplier->load(['products', 'createdBy', 'updatedBy']);

        return $this->successResponse($supplier, 'Supplier retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierRequest $request, Supplier $supplier): JsonResponse
    {
        $data = $request->validated();
        
        // Set updated_by
        $data['updated_by'] = auth()->id();

        $supplier->update($data);

        $supplier->load(['createdBy', 'updatedBy']);

        return $this->successResponse($supplier, 'Supplier updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier): JsonResponse
    {
        // Check if supplier has products
        if ($supplier->products()->exists()) {
            return $this->errorResponse('Cannot delete supplier with products', Response::HTTP_CONFLICT);
        }

        $supplier->delete();

        return $this->successResponse(null, 'Supplier deleted successfully');
    }
}
