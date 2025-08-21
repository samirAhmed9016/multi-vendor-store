<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $products = Product::filter($request->query())
            ->with(['store', 'category', 'tags'])
            ->paginate();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'in:active,inactive',
        ]);
        $product = Product::create($request->all());
        return response()->json(
            $product,
            201,
            [
                'location' => route('products.show', $product->id)
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
        // $product->load(['store:id,name', 'category:id,name']);
        // return $product;
    }
    // public function show(string $id)
    // {
    //     $product = Product::with(['store', 'category', 'tags'])->findOrFail($id);
    //     return response()->json($product);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'store_id' => 'sometimes|exists:stores,id',
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'slug' => 'nullable|string|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'compare_price' => 'nullable|numeric|gt:price',
            'options' => 'nullable|array',
            'rating' => 'nullable|numeric|min:0|max:5',
            'featured' => 'nullable|boolean',
            'status' => 'in:active,draft,archived',
        ]);

        // Update product
        $product->update($request->all());

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product->fresh(['store', 'category', 'tags'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);
        // $product = Product::findOrFail($id);
        // $product->delete();
        return [
            'message' => 'Product deleted successfully',

        ];
    }
}
