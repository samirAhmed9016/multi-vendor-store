@extends('layout.dashboard')

@section('title', 'categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection
@section('contents')
    <style>
        .table td {
            vertical-align: middle;
        }
    </style>
    <div class="mb-5">
        @if (Auth::user()->can('categories.create'))
            <a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create new
                category</a>
        @endif

        <a href="{{ route('dashboard.categories.trash') }}" class="btn btn-sm btn-outline-dark">Trash</a>
    </div>

    {{-- @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif --}}
    {{-- comment --}}


    <x-alert type="success" />
    <x-alert type="info" />



    {{-- <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
        <x-form.input name="name" placeholder="Name" />
        <select name="status" class="form-control">
            <option value="">All</option>
            <option value="active">Active</option>
            <option value="arcived">Arcived</option>
        </select>
        <button class="btn btn-dark">Filter</button>
    </form> --}}

    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
        <!-- Name Input -->
        <x-form.input name="name" placeholder="Name" class="form-control me-2" />

        <!-- Status Dropdown -->
        <select name="status" class="form-select me-2" style="max-width: 200px;">
            <option value="">All</option>
            <option value="active">Active</option>
            <option value="archived">Archived</option> <!-- Corrected spelling mistake -->
        </select>

        <!-- Filter Button -->
        <button class="btn btn-dark">Filter</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>image</th>
                <th>ID</th>
                <th>Name</th>
                <th>Parent</th>
                <th>products number</th>
                <th>Status</th>
                {{-- <th>N_products</th> --}}
                <th>Created At</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr class="center-align">
                    <td>
                        @if (!empty($category->image) && file_exists(public_path('storage/' . $category->image)))
                            <img src="{{ asset('storage/' . $category->image) }}" alt="samir"
                                style="width: 100px; height: auto; border: 1px solid #ccc; padding: 5px;">
                        @endif
                    </td>
                    <td>{{ $category->id }}</td>
                    <td>
                        <a href="{{ route('dashboard.categories.show', $category->id) }}">{{ $category->name }}</a>
                    </td>
                    <td>{{ $category->parent->name }}</td>
                    <td>{{ $category->products_count }}</td>
                    <td>{{ $category->status }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>
                        @can('categories.update')
                            <a href="{{ route('dashboard.categories.edit', $category->id) }}"
                                class="btn btn btn-sm btn-primary">Edit</a>
                        @endcan

                        @can('categories.delete')
                            <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="post"
                                style="display: inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No categories found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $categories->withQueryString()->links() }}

@endsection
