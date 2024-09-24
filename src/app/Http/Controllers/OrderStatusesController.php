<?php

namespace App\Http\Controllers;

use App\Models\Order_statuses;
use Illuminate\Http\Request;

class OrderStatusesController extends Controller
{
    public function updateOrderStatus($orderId, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,canceled',
        ]);

        $orderStatus = Order_statuses::where('order_id', $orderId)->first();

        if ($orderStatus) {
            $orderStatus->update([
                'status' => $validated['status'],
            ]);

            return response()->json(['message' => 'Order status updated successfully']);
        }

        return response()->json(['message' => 'Order not found'], 404);
    }
}
