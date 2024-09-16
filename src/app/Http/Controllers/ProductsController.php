<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Products::with('sizes')->get();
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'sizes' => 'required|array', // Validation for sizes array
            'sizes.*.size' => 'required|string|in:small,medium,large', // Validating size names
            'sizes.*.price' => 'required|numeric|min:0', // Validating prices
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
        }

        $product = Products::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image_at' => $imagePath
        ]);

        // Save sizes with their respective prices
        foreach ($validated['sizes'] as $size) {
            ProductSize::create([
                'products_id' => $product->id,
                'size' => $size['size'],
                'price' => $size['price']
            ]);
        }

        return response()->json([
            'message' => 'Product created successfully!',
            'image' => $imagePath,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Products::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Products::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'sizes' => 'sometimes|array',
            'sizes.*.size' => 'required_with:sizes|string|in:small,medium,large',
            'sizes.*.price' => 'required_with:sizes|numeric|min:0',
        ]);

        $product->update($validated);

        // Update sizes if provided
        if (isset($validated['sizes'])) {
            // Clear existing sizes
            $product->sizes()->delete();

            // Add new sizes
            foreach ($validated['sizes'] as $size) {
                ProductSize::create([
                    'products_id' => $id,
                    'size' => $size['size'],
                    'price' => $size['price']
                ]);
            }
        }

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Products::destroy($id);
        return response()->json(['message' => 'Product deleted']);
    }
}
