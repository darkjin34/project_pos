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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'category' => 'required|string|in:coffee,dish', // Added category validation
            'sizes' => 'required|array',
            'sizes.*.size' => 'nullable|string|in:small,medium,large',
            'sizes.*.price' => 'required|numeric|min:0',
            'sizes.*.temperature' => 'nullable|string|in:hot,cold', // Added temperature validation
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
        }

        $product = Products::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'category' => $validated['category'], // Store category
            'image_at' => $imagePath
        ]);

        // Save sizes with their respective prices and temperatures
        foreach ($validated['sizes'] as $size) {
            ProductSize::create([
                'products_id' => $product->id,
                'size' => $size['size'],
                'price' => $size['price'],
                'temperature' => $size['temperature'], // Save hot/cold option
            ]);
        }

        return response()->json([
            'message' => 'Product created successfully!',
            'image' => $imagePath,
        ], 201);
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
            'category' => 'sometimes|required|string|in:coffee,dish', // Added category validation for update
            'sizes' => 'sometimes|array',
            'sizes.*.size' => 'required_with:sizes|string|in:small,medium,large',
            'sizes.*.price' => 'required_with:sizes|numeric|min:0',
            'sizes.*.temperature' => 'required_with:sizes|string|in:hot,cold', // Validate hot/cold
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
                    'price' => $size['price'],
                    'temperature' => $size['temperature'], // Update temperature
                ]);
            }
        }

        return response()->json($product);
    }

    /**
     * Display a listing of products filtered by category.
     */
    public function getProductsByCategory($category)
    {
        return Products::with('sizes')
            ->where('category', $category)
            ->get();
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
