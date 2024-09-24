<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    
    public function updatePaymentStatus($orderId, Request $request)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:paid,unpaid,refunded',
        ]);

        $payment = Payments::where('order_id', $orderId)->first();

        if ($payment) {
            $payment->update([
                'payment_status' => $validated['payment_status'],
            ]);

            return response()->json(['message' => 'Payment status updated successfully']);
        }

        return response()->json(['message' => 'Payment not found'], 404);
    }
}
