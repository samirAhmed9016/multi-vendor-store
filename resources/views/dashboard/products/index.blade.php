@extends('layout.dashboard')

@section('title', 'products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">products</li>
@endsection
@section('contents')
    <style>
        .table th {
            text-align: center;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
        }
    </style>
    <div class="mb-5">
        <a href="{{ route('dashboard.products.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create new
            product</a>
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
                <th>ID</th>
                <th>Name</th>
                <th>Category_id</th>
                <th>Store_id</th>
                <th>Status</th>
                <th>Created At</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr class="center-align">

                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->store->name }}</td>
                    <td>{{ $product->status }}</td>
                    <td>{{ $product->created_at }}</td>
                    <td>
                        <a href="{{ route('dashboard.products.edit', $product->id) }}"
                            class="btn btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="post"
                            style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No products found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $products->withQueryString()->links() }}

@endsection
