@extends('layout.dashboard')

@section('title', $category->name)

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">{{ $category->name }}</li>
@endsection

@section('contents')



    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Store</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @php
                $products = $category->products()->with('store')->paginate(5);

            @endphp
            @forelse ($products as $product)
                <tr class="center-align">

                    <td></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->store->name }}</td>
                    <td>{{ $product->status }}</td>
                    <td>{{ $product->created_at }}</td>

                </tr>
            @empty
                <tr>
                    <td colspan="5">No products found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $products->links() }}

@endsection
