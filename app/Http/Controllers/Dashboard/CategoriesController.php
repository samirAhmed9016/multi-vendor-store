<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {



        if (Gate::denies('categories.view')) {
            abort(403, 'Unauthorized action.');
        }


        $request = request();


        // $categories = Category::with('parent')
        //     // )->leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')

        //     //     ->select(['categories.*', 'parents.name as parent_name'])
        //     ->select('categories.*')
        //     // ->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as products_count ')
        //     ->addSelect(DB::raw("(SELECT COUNT(*) FROM products WHERE category_id = categories.id AND status = 'active') as products_count"))
        //     // ->withCount('products')
        //     ->Filter($request->query())
        //     // ->dd();
        //     ->paginate(10);



        $categories = Category::with('parent')
            ->select('categories.*')
            ->addSelect(DB::raw("(SELECT COUNT(*) FROM products WHERE category_id = categories.id AND status = 1) as products_count"))
            ->Filter($request->query())
            ->paginate(10);





        return view('dashboard.categories.index', compact('categories'));
    }
    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index()
    // {
    //     // $categories = Category::all();

    //     // $categories = Category::simplePaginate(4);
    //     $request = request();
    //     // $query = Category::query();
    //     // $name = $request->query('name');
    //     // if ($name) {
    //     //     $query->where('name', 'LIKE', "%{$name}%");
    //     // }
    //     // if ($status = $request->query('status')) {
    //     //     $query->whereStatus($status);
    //     // }


    //     $categories = Category::Filter($request->query())->paginate(4);

    //     return view('dashboard.categories.index', compact('categories'));
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        if (Gate::denies('categories.create')) {
            abort(403, 'Unauthorized action.');
        }


        $parents = Category::all();
        return view('dashboard.categories.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //Validate the request data
    // $request->validate([
    //     'name' => 'required|string|max:255',
    //     'parent_id' => 'nullable|exists:categories,id',
    //     'Description' => 'nullable|string',
    //     'status' => 'required|in:active,inactive',
    //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    // ]);

    // Handle file upload if an image is provided
    // if ($request->hasFile('image')) {
    //     $imagePath = $request->file('image')->store('images', 'public');
    // } else {
    //     $imagePath = null;
    // }

    // $category = new Category;
    // $category->name = $request->name;
    // $category->parent_id = $request->parent_id;
    // $category->description = $request->Description;
    // $category->status = $request->status;
    // $category->slug = 'slug1';
    // $category->image = $imagePath;
    // $category->save();


    // return redirect()->route('categories.index')->with('success', 'Category created successfully.');


    // $request->input('name');

    // $request->post('name');
    // $request->query('name');
    // $request->get('name');
    // $request->name;
    // $request['name'];

    // $request->all();
    // $request->only('name', 'image');
    // $request->except('name', 'image');


    // $category = new Category(
    //     $request->all()
    // );
    // $category->name = $request->post('name');
    // $category->parent_id = $request->post('parent_id');
    // $category->description = $request->post('description');
    // $category->save();

    //     $request->merge([
    //         'slug' => Str::slug($request->post('name'))
    //     ]);

    //     $data = $request->except('image');
    //     $data['image'] = $this->upload_file($request);

    //     $category = Category::create($data);
    //PRG
    //     return redirect()->route('dashboard.categories.index')->with('success', 'Category created successfully.');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {



        // Validate the request data

        // $request->validate([
        //     'name' => 'required|string|min:3|max:255',
        //     'parent_id' => ['int', 'exists:categories,id'],
        //     'description' => 'string',
        //     'image' => 'image',
        //     'status' => 'in:active,archived',
        // ]);

        // $request->validate(Category::rules());







        // Merge the slug into the request data
        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);

        // Handle file upload if an image is provided
        $data = $request->except('image');
        $data['image'] = $this->uploadFile($request);

        // Create the category
        $category = Category::create($data);

        // Redirect to the categories index page with a success message
        return redirect()->route('dashboard.categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Handle file upload.
     */
    private function uploadFile(Request $request)
    {
        if ($request->hasFile('image')) {
            return $request->file('image')->store('images', 'public');
        }

        return null;
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {

        if (Gate::denies('categories.view')) {
            abort(403, 'Unauthorized action.');
        }

        // Eager load the products related to the category
        $category->load('products');

        return view('dashboard.categories.show', [
            'category' => $category,
            'products' => $category->products
        ]);
    }












    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        Gate::authorize('categories.update');

        $parents = Category::all();
        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $id);
            })
            ->get();

        $category = Category::find($id);
        if (!$category) {
            abort(404);
        }
        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        Gate::authorize('categories.update');


        $request->validate(Category::rules());

        $category = Category::find($id);
        $old_image = $category->image;

        $data = $request->except('image');
        $new_imagePath = $this->upload_file($request);

        if ($new_imagePath) {
            $data['image'] = $new_imagePath;
        }


        if ($old_image && $new_imagePath) {
            Storage::disk('public')->delete($old_image);
        }

        // $category->fill($request->all())->save();
        $category->update($data);
        $category->slug = Str::slug($request->post('name'));
        $category->save();
        //PRG
        return redirect()->route('dashboard.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('categories.delete');
        // Category::destroy($id);
        // Category::where('id', '=', $id)->delete();
        $category = Category::findOrFail($id);
        $category->delete();



        return Redirect::route('dashboard.categories.index')
            ->with('success', 'Category deleted successfully');
    }

    protected function upload_file(Request $request)
    {
        if (!$request->hasFile('image')) {
            return null;  // Return null if no file is uploaded
        }

        $file = $request->file('image');
        $imagePath = $file->store('uploads', 'public');

        return $imagePath;
    }







    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate(4);
        return view('dashboard.categories.trash', compact('categories'));
    }
    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('dashboard.categories.trash')->with('success', 'Category restored!');
    }
    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.trash')->with('success', 'Category deleted forever!');
    }
}
