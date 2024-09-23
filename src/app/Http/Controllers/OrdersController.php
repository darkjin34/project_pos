<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\ProductSize;
use App\Models\Order_statuses;
use App\Models\Payments;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_name' => 'nullable|string',
            'total_price' => 'required|numeric',
            'order_items' => 'required|array',
            'order_items.*.product_size_id' => 'required|exists:product_sizes,id',
            'order_items.*.quantities' => 'required|integer|min:1',
        ]);
    
        // Create Order
        $order = Orders::create([
            'order_number' => uniqid('ORDER_'),
            'customer_name' => $validatedData['customer_name'],
            'total_price' => $validatedData['total_price'],
            'status' => 'pending',
        ]);
    
        // Create Order Items
        foreach ($validatedData['order_items'] as $item) {
            $order->orderItems()->create([
                'product_size_id' => $item['product_size_id'],
                'quantity' => $item['quantities'],
                'subtotal' => $item['quantities'] * ProductSize::find($item['product_size_id'])->price,
            ]);
        }

        // Set the initial order status
        Order_statuses::create([
            'order_id' => $order->id,
            'status' => 'pending', // Initial status
        ]);

        // Create the payment record
        Payments::create([
            'order_id' => $order->id,
            'amount' => $validatedData['total_price'],
            'payment_method' => 'cash',
            'payment_status' => 'unpaid', // Payment status can be updated later
        ]);
    
        return response()->json(['message' => 'Order placed successfully', 'order' => $order]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orders $orders)
    {
        //
    }
}
