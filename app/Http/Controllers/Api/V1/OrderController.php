<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\OrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Order::with(['user', 'orderStatus', 'orderItems', 'creator', 'updater']);

        // Apply filters
        if ($request->has('order_status_id')) {
            $query->where('order_status_id', $request->order_status_id);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('user_id', 'like', '%' . $request->search . '%');
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $orders = $query->paginate($perPage);

        return $this->successResponse($orders, 'Orders retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Set created_by and updated_by
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        $order = Order::create($data);

        $order->load(['user', 'orderStatus', 'orderItems', 'creator', 'updater']);

        return $this->successResponse($order, 'Order created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): JsonResponse
    {
        $order->load(['user', 'orderStatus', 'orderItems.product', 'creator', 'updater']);

        return $this->successResponse($order, 'Order retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, Order $order): JsonResponse
    {
        $data = $request->validated();
        
        // Set updated_by
        $data['updated_by'] = auth()->id();

        $order->update($data);

        $order->load(['user', 'orderStatus', 'orderItems', 'creator', 'updater']);

        return $this->successResponse($order, 'Order updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): JsonResponse
    {
        // Check if order has items
        if ($order->orderItems()->exists()) {
            return $this->errorResponse('Cannot delete order with items', Response::HTTP_CONFLICT);
        }

        $order->delete();

        return $this->successResponse(null, 'Order deleted successfully');
    }
}
