<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\ShippingRequest;
use App\Models\ShippingZone;
use App\Models\ShippingRate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShippingController extends BaseApiController
{
    /**
     * Display a listing of shipping zones.
     */
    public function index(Request $request): JsonResponse
    {
        $query = ShippingZone::with(['countries', 'shippingRates', 'createdBy', 'updatedBy']);

        // Apply filters
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
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
        $shippingZones = $query->paginate($perPage);

        return $this->successResponse($shippingZones, 'Shipping zones retrieved successfully');
    }

    /**
     * Store a newly created shipping zone.
     */
    public function store(ShippingRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Set created_by and updated_by
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $shippingZone = ShippingZone::create($data);

        $shippingZone->load(['countries', 'shippingRates', 'createdBy', 'updatedBy']);

        return $this->successResponse($shippingZone, 'Shipping zone created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified shipping zone.
     */
    public function show(ShippingZone $shippingZone): JsonResponse
    {
        $shippingZone->load(['countries', 'shippingRates', 'createdBy', 'updatedBy']);

        return $this->successResponse($shippingZone, 'Shipping zone retrieved successfully');
    }

    /**
     * Update the specified shipping zone.
     */
    public function update(ShippingRequest $request, ShippingZone $shippingZone): JsonResponse
    {
        $data = $request->validated();
        
        // Set updated_by
        $data['updated_by'] = auth()->id();

        $shippingZone->update($data);

        $shippingZone->load(['countries', 'shippingRates', 'createdBy', 'updatedBy']);

        return $this->successResponse($shippingZone, 'Shipping zone updated successfully');
    }

    /**
     * Remove the specified shipping zone.
     */
    public function destroy(ShippingZone $shippingZone): JsonResponse
    {
        // Check if shipping zone has rates
        if ($shippingZone->shippingRates()->exists()) {
            return $this->errorResponse('Cannot delete shipping zone with rates', Response::HTTP_CONFLICT);
        }

        $shippingZone->delete();

        return $this->successResponse(null, 'Shipping zone deleted successfully');
    }

    /**
     * Display a listing of shipping rates.
     */
    public function rates(Request $request): JsonResponse
    {
        $query = ShippingRate::with(['shippingZone', 'createdBy', 'updatedBy']);

        // Apply filters
        if ($request->has('shipping_zone_id')) {
            $query->where('shipping_zone_id', $request->shipping_zone_id);
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $shippingRates = $query->paginate($perPage);

        return $this->successResponse($shippingRates, 'Shipping rates retrieved successfully');
    }
}
