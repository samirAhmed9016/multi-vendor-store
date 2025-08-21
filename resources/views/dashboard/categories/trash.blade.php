@extends('layout.dashboard')

@section('title', 'Trashed categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item ">Categories</li>
    <li class="breadcrumb-item active">Trash</li>
@endsection
@section('contents')
    <style>
        .table td {
            vertical-align: middle;
        }
    </style>
    <div class="mb-5">
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-sm btn-outline-primary">Back</a>
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
                <th>Status</th>
                <th>Deleted At</th>
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
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->status }}</td>
                    <td>{{ $category->deleted_at }}</td>
                    <td>

                        <form action="{{ route('dashboard.categories.restore', $category->id) }}" method="post"
                            style="display: inline-block">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-info">Restore</button>
                        </form>

                        <form action="{{ route('dashboard.categories.force-delete', $category->id) }}" method="post"
                            style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No categories found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $categories->withQueryString()->links() }}

@endsection
