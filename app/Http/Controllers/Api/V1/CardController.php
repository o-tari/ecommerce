<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\CardRequest;
use App\Models\Card;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CardController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Card::with(['customer', 'cardItems.product', 'createdBy', 'updatedBy']);

        // Apply filters
        if ($request->has('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $query->whereHas('customer', function($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $cards = $query->paginate($perPage);

        return $this->successResponse($cards, 'Cards retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CardRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Set created_by and updated_by
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $card = Card::create($data);

        $card->load(['customer', 'cardItems.product', 'createdBy', 'updatedBy']);

        return $this->successResponse($card, 'Card created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Card $card): JsonResponse
    {
        $card->load(['customer', 'cardItems.product', 'createdBy', 'updatedBy']);

        return $this->successResponse($card, 'Card retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CardRequest $request, Card $card): JsonResponse
    {
        $data = $request->validated();
        
        // Set updated_by
        $data['updated_by'] = auth()->id();

        $card->update($data);

        $card->load(['customer', 'cardItems.product', 'createdBy', 'updatedBy']);

        return $this->successResponse($card, 'Card updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card): JsonResponse
    {
        // Check if card has items
        if ($card->cardItems()->exists()) {
            return $this->errorResponse('Cannot delete card with items', Response::HTTP_CONFLICT);
        }

        $card->delete();

        return $this->successResponse(null, 'Card deleted successfully');
    }
}
