<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    
    public function index()
    {
        //
    }

    public function store(Request $request, $productId)
    {
        $request->validate([
            'reviewer_name' => 'required|string|max:255',
            'comment'       => 'required|string',
            'rating'        => 'required|integer|min:1|max:5',
        ]);

        $product = Product::findOrFail($productId);

        $review = $product->reviews()->create($request->all());

        return response()->json($review, 201);
    }

    public function show($id)
    {
        $review = Review::with('product')->find($id);

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $review
        ], 200);
    }

    // public function show($id)
    // {
    //     $review = Review::find($id);
    //     if ($review) {
    //         return new ReviewResource($review);
    //     } else {
    //         return response()->json(['message' => 'review not found'], 404);
    //     }
    // }

    // GET /reviews/{id} → single review with product
    // public function show($id)
    // {
    //     $review = Review::with('product')->findOrFail($id);
    //     if($review){
    //         return new ReviewResource($review);
    //     } else {
    //         return response()->json(['message' => 'Review not found'], 20);
    //     } 
    // }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
