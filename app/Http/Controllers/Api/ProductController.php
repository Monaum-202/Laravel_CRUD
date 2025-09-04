<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['detail', 'reviews'])->get();

        if ($products->count() > 0) {
            return ProductResource::collection($products);
        } else {
            return response()->json(['message' => 'No products found'], 200);
        }
    }
    

    public function store(Request $request)
{
    // 1. Validate input
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        // Product detail fields
        'specifications' => 'nullable|string',
        'manufacturer'   => 'nullable|string|max:255',
        'warranty'       => 'nullable|string|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    $data = $validator->validated();

    // 2. Handle image upload if exists
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('products', 'public');
    }

    // 3. Create product
    $product = Product::create($data);

    // 4. Create product detail
    $product->detail()->create([
        'specifications' => $data['specifications'] ?? null,
        'manufacturer'   => $data['manufacturer'] ?? null,
        'warranty'       => $data['warranty'] ?? null,
    ]);

    // 5. Return JSON response
    return response()->json([
        'message' => 'Product Created Successfully',
        'data' => new ProductResource($product->load('detail')), // Load relationship
        'success' => true
    ], 201);
}


    // public function show($id)
    // {
    //     $product = Product::find($id);
    //     if ($product) {
    //         return new ProductResource($product);
    //     } else {
    //         return response()->json(['message' => 'Product not found'], 404);
    //     }
    // }
    // GET /products/{id}
    public function show($id)
    {
        $product = Product::with(['detail', 'reviews'])->find($id);

        if ($product) {
            return new ProductResource($product);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $product->update($validator->validated());

        return response()->json([
            'message' => 'Product Updated Successfully',
            'data' => new ProductResource($product),
            'success' => true
        ], 200);
    }


    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product Deleted Successfully',
            'success' => true
        ], 200);
    }

    // public function show($id)
    // {
    //     $product = Product::find($id);
    //     if ($product) {
    //         return new ProductResource($product);
    //     } else {
    //         return response()->json(['message' => 'Product not found'], 404);
    //     }
    // }
}
