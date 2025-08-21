@extends('layout.dashboard')

@section('contents')
    <div class="container">
        <h2>Edit Product</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('dashboard.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}">
            </div>

            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $product->slug) }}">
            </div>



            <div class="form-group">
                <label for="">Category parent</label>
                <select name="parent_id" class="form-control form-select">
                    <option value="">Select Category</option>
                    @foreach (App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id == $category->id))>
                            {{ $category->name }}
                        </option>
                    @endforeach

                </select>
            </div>








            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" name="image" class="form-control">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100"
                        height="100">
                @endif
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" step="0.01" name="price" class="form-control"
                    value="{{ old('price', $product->price) }}">
            </div>

            <div class="form-group">
                <label for="compare_price">Compare Price</label>
                <input type="number" step="0.01" name="compare_price" class="form-control"
                    value="{{ old('compare_price', $product->compare_price) }}">
            </div>

            {{-- <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" class="form-control">
                    <option value="">Select a Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="store_id">Store</label>
                <select name="store_id" class="form-control" required>
                    @foreach ($stores as $store)
                        <option value="{{ $store->id }}" {{ $store->id == $product->store_id ? 'selected' : '' }}>
                            {{ $store->name }}
                        </option>
                    @endforeach
                </select>
            </div> --}}


            <div class="form-group">
                {{-- <label for="">Tags</label>
                <input type="text" name="tags" class="form-control" value=""> --}}
                <x-form.input label="Tags" name="tags" :value="$tags" />
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="archived" {{ $product->status == 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />


    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <script>
        var inputElm = document.querySelector('[name=tags]'),
            tagify = new Tagify(inputElm);
    </script>
@endsection
