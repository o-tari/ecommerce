<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CouponController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Coupon::with(['products', 'createdBy', 'updatedBy']);

        // Apply filters
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->has('discount_type')) {
            $query->where('discount_type', $request->discount_type);
        }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('code', 'like', '%' . $request->search . '%')
                  ->orWhere('name', 'like', '%' . $request->search . '%');
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $coupons = $query->paginate($perPage);

        return $this->successResponse($coupons, 'Coupons retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Set created_by and updated_by
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $coupon = Coupon::create($data);

        $coupon->load(['createdBy', 'updatedBy']);

        return $this->successResponse($coupon, 'Coupon created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon): JsonResponse
    {
        $coupon->load(['products', 'createdBy', 'updatedBy']);

        return $this->successResponse($coupon, 'Coupon retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponRequest $request, Coupon $coupon): JsonResponse
    {
        $data = $request->validated();
        
        // Set updated_by
        $data['updated_by'] = auth()->id();

        $coupon->update($data);

        $coupon->load(['createdBy', 'updatedBy']);

        return $this->successResponse($coupon, 'Coupon updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon): JsonResponse
    {
        // Check if coupon has products
        if ($coupon->products()->exists()) {
            return $this->errorResponse('Cannot delete coupon with products', Response::HTTP_CONFLICT);
        }

        $coupon->delete();

        return $this->successResponse(null, 'Coupon deleted successfully');
    }
}
