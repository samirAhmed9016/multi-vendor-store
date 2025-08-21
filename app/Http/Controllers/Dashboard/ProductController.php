<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;


class ProductController extends Controller
{


    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $this->authorize('viewAny', Product::class);


        // if (Gate::denies('products.view')) {
        //     abort(403, 'Unauthorized action.');
        // }
        // $user = Auth::user();

        // if ($user->store_id) {
        //     $products = Product::where('store_id', '=', $user->store_id)->paginate();
        // } else {

        //     $products = Product::where()->paginate();
        // }
        $products = Product::with(['category', 'store'])->paginate(50);

        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('create', Product::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $this->authorize('create', Product::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        // $this->authorize('view', $product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {


    //     $product = Product::findOrFail($id);
    //     // $this->authorize('update', $product);



    //     // $user = Auth::user();

    //     // if ($user->store_id) {
    //     //     $product = Product::where('store_id', '=', $user->store_id)->findOrFail($id);
    //     // } else {

    //     //     $product = Product::findOrFail($id);
    //     // }

    //     $tags = implode(',', $product->tags()->pluck('name')->toArray());
    //     return view('dashboard.products.edit', compact('product', 'tags'));
    // }

    public function edit(Product $product)
    {
        $tags = implode(',', $product->tags()->pluck('name')->toArray());
        return view('dashboard.products.edit', compact('product', 'tags'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        // $this->authorize('update', $product);


        $product->update($request->except('tags'));

        $tags = json_decode($request->post('tags'));
        $tag_ids = [];
        $saved_tags = Tag::all();


        foreach ($tags as $item) {
            $slug = Str::slug($item->value);


            $tag = $saved_tags->where('slug', $slug)->first();
            if (!$tag) {
                $tag = Tag::create([
                    'name' => $item->value,
                    'slug' => $slug
                ]);
            }
            $tag_ids[] = $tag->id;
        }

        $product->tags()->sync($tag_ids);



        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        // $this->authorize('delete', $product);
    }
}
