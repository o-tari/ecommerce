<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserDashboardStatisticsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $totalOrdersPlaced = Order::where('user_id', $user->id)->count();
        $totalAmountSpent = Order::where('user_id', $user->id)->sum('total_amount');
        $averageOrderValue = $totalOrdersPlaced > 0 ? $totalAmountSpent / $totalOrdersPlaced : 0;
        $ordersLast30Days = Order::where('user_id', $user->id)->where('created_at', '>=', Carbon::now()->subDays(30))->count();

        $pendingStatusId = OrderStatus::where('status_name', 'pending')->value('id');
        $activeOrders = Order::where('user_id', $user->id)
            ->where('order_status_id', $pendingStatusId)
            ->with('orderStatus')
            ->get()
            ->map(function ($order) {
                return [
                    'order_number' => $order->order_number,
                    'total_amount' => number_format($order->total_amount, 2, '.', ''),
                    'status' => $order->orderStatus ? $order->orderStatus->status_name : null,
                    'estimated_delivery_date' => $order->estimated_delivery_date,
                    'created_at' => $order->created_at,
                ];
            });

        $availableCoupons = Coupon::where('coupon_end_date', '>=', Carbon::now())
            ->where('coupon_start_date', '<=', Carbon::now())
            ->get()
            ->map(function ($coupon) {
                return [
                    'code' => $coupon->code,
                    'discount' => $coupon->discount_type === 'percentage' ? $coupon->discount_value . '%' : '$' . $coupon->discount_value,
                    'expires_on' => $coupon->coupon_end_date,
                ];
            });

        $topPurchasedItems = OrderItem::whereIn('order_id', Order::where('user_id', $user->id)->pluck('id'))
            ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->with('product')
            ->get()
            ->map(function ($item) {
                return [
                    'product_name' => $item->product ? $item->product->product_name : 'Unknown Product',
                    'total_quantity' => (int)$item->total_quantity,
                    'image_url' => $item->product ? $item->product->getFirstMediaUrl('product_images') : null,
                ];
            });

        $returnedStatusId = OrderStatus::where('status_name', 'returned')->value('id');
        $returnedOrdersCount = Order::where('user_id', $user->id)
            ->where('order_status_id', $returnedStatusId)
            ->count();

        return response()->json([
            'total_orders_placed' => $totalOrdersPlaced,
            'total_amount_spent' => number_format($totalAmountSpent, 2, '.', ''),
            'average_order_value' => number_format($averageOrderValue, 2, '.', ''),
            'orders_last_30_days' => $ordersLast30Days,
            'active_orders' => $activeOrders,
            'available_coupons' => $availableCoupons,
            'top_purchased_items' => $topPurchasedItems,
            'returned_orders_count' => $returnedOrdersCount,
        ]);
    }
}