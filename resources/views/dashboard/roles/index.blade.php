@extends('layout.dashboard')

@section('title', 'roles')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Roles</li>
@endsection
@section('contents')
    <style>
        .table td {
            vertical-align: middle;
        }
    </style>
    <div class="mb-5">

        <a href="{{ route('dashboard.roles.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create new
            role</a>


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
    {{--
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
    </form> --}}

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Created At</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($roles as $role)
                <tr class="center-align">
                    <td>{{ $role->id }}</td>
                    <td>
                        <a href="{{ route('dashboard.roles.show', $role->id) }}">{{ $role->name }}</a>
                    </td>
                    <td>{{ $role->created_at }}</td>
                    <td>

                        <a href="{{ route('dashboard.roles.edit', $role->id) }}" class="btn btn btn-sm btn-primary">Edit</a>



                        <form action="{{ route('dashboard.roles.destroy', $role->id) }}" method="post"
                            style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No roles found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $roles->withQueryString()->links() }}

@endsection
