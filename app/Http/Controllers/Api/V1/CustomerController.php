<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Customer::with(['addresses', 'orders', 'createdBy', 'updatedBy']);

        // Apply filters
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('company', 'like', '%' . $request->search . '%');
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $customers = $query->paginate($perPage);

        return $this->successResponse($customers, 'Customers retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Set created_by and updated_by
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $customer = Customer::create($data);

        $customer->load(['addresses', 'createdBy', 'updatedBy']);

        return $this->successResponse($customer, 'Customer created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer): JsonResponse
    {
        $customer->load(['addresses', 'orders.orderItems.product', 'createdBy', 'updatedBy']);

        return $this->successResponse($customer, 'Customer retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, Customer $customer): JsonResponse
    {
        $data = $request->validated();
        
        // Set updated_by
        $data['updated_by'] = auth()->id();

        $customer->update($data);

        $customer->load(['addresses', 'createdBy', 'updatedBy']);

        return $this->successResponse($customer, 'Customer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): JsonResponse
    {
        // Check if customer has orders
        if ($customer->orders()->exists()) {
            return $this->errorResponse('Cannot delete customer with orders', Response::HTTP_CONFLICT);
        }

        $customer->delete();

        return $this->successResponse(null, 'Customer deleted successfully');
    }
}
