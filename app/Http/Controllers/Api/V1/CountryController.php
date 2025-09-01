<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\CountryRequest;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CountryController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Country::with(['createdBy', 'updatedBy']);

        // Apply filters
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $countries = $query->paginate($perPage);

        return $this->successResponse($countries, 'Countries retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Set created_by and updated_by
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $country = Country::create($data);

        $country->load(['createdBy', 'updatedBy']);

        return $this->successResponse($country, 'Country created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country): JsonResponse
    {
        $country->load(['createdBy', 'updatedBy']);

        return $this->successResponse($country, 'Country retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CountryRequest $request, Country $country): JsonResponse
    {
        $data = $request->validated();
        
        // Set updated_by
        $data['updated_by'] = auth()->id();

        $country->update($data);

        $country->load(['createdBy', 'updatedBy']);

        return $this->successResponse($country, 'Country updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country): JsonResponse
    {
        $country->delete();

        return $this->successResponse(null, 'Country deleted successfully');
    }
}
