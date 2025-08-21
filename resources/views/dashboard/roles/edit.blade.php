{{-- @extends('layout.dashboard')

@section('title', 'Edit Category')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.roles.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">Edit Category</li>
@endsection

@section('contents')
    <style>
        body {
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
            position: relative;
            height: 100vh;
        }

        .form-container {
            max-width: 700px;
            margin: 50px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 10;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .custom-file-label::after {
            content: "Browse";
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .tooltip-inner {
            max-width: 250px;
            padding: 8px;
            color: #fff;
            background-color: #000;
            border-radius: 5px;
        }

        .background-element {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('path_to_seka_image.jpg') no-repeat center center;
            background-size: cover;
            z-index: 1;
        }
    </style>

    <div class="background-element"></div>
    <div class="container">
        <div class="form-container">
            <h2 class="mb-4 text-center">Edit Category</h2>
            <form action="{{ route('dashboard.roles.update', $role->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter name"
                        value="{{ $role->name }}" data-toggle="tooltip" data-placement="right"
                        title="Enter the name of the role.">
                </div>

                <div class="form-group">
                    <label for="parent_id">Parent Category</label>
                    <select name="parent_id" class="form-control" id="parent_id" data-toggle="tooltip"
                        data-placement="right" title="Select a parent role if applicable.">
                        <option value="">Primary Category</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}" {{ $role->parent_id == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="Description">Description</label>
                    <textarea name="Description" class="form-control" id="Description" placeholder="Enter Description" data-toggle="tooltip"
                        data-placement="right" title="Provide a brief description of the role.">{{ $role->description }}</textarea>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="status_active" name="status" value="active"
                            data-toggle="tooltip" data-placement="right" title="Set the role as active."
                            {{ $role->status == 'active' ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_active">Active</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="status_archived" name="status" value="archived"
                            data-toggle="tooltip" data-placement="right" title="Set the role as archived."
                            {{ $role->status == 'archived' ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_archived">Archived</label>
                    </div>
                </div>

                {{-- <div class="form-group">
                    <label for="image">Image</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image" data-toggle="tooltip"
                            data-placement="right" title="Upload an image representing the role.">
                        <label class="custom-file-label" for="image">{{ $role->image }}</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image" data-toggle="tooltip"
                            data-placement="right" title="Upload an image representing the role."
                            onchange="updateFileName()">
                        <label class="custom-file-label" for="image">{{ $role->image ?? 'Choose file' }}</label>
                    </div>
                </div>

                <script>
                    function updateFileName() {
                        const input = document.getElementById('image');
                        const label = input.nextElementSibling;
                        const fileName = input.files[0] ? input.files[0].name : 'Choose file';
                        label.textContent = fileName;
                    }
                </script>
                <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
            </form>
        </div>
    </div>
@endsection --}}





@extends('layout.dashboard')

@section('title', 'Edit Role')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active">Edit Role</li>
@endsection

@section('contents')
    <div class="container">
        <div class="form-container">
            <h2 class="mb-4 text-center">Edit Role</h2>

            <form action="{{ route('dashboard.roles.update', $role->id) }}" method="post">
                @csrf
                @method('PUT')

                <div class="form-group mb-4">
                    <x-form.input class="form-control" type="text" name="name" label="Role Name"
                        value="{{ $role->name }}" />
                </div>

                <fieldset>
                    <legend>{{ __('Abilities') }}</legend>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Ability</th>
                                <th class="text-center">Allow</th>
                                <th class="text-center">Deny</th>
                                <th class="text-center">Inherit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (app('abilities') as $ability_code => $ability_name)
                                <tr>
                                    <td>{{ $ability_name }}</td>
                                    <td class="text-center">
                                        <input type="radio" name="abilities[{{ $ability_code }}]" value="allow"
                                            @checked(($role_abilities[$ability_code] ?? '') === 'allow')>
                                    </td>
                                    <td class="text-center">
                                        <input type="radio" name="abilities[{{ $ability_code }}]" value="deny"
                                            @checked(($role_abilities[$ability_code] ?? '') === 'deny')>
                                    </td>
                                    <td class="text-center">
                                        <input type="radio" name="abilities[{{ $ability_code }}]" value="inherit"
                                            @checked(($role_abilities[$ability_code] ?? '') === 'inherit')>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </fieldset>

                <button type="submit" class="btn btn-primary btn-block mt-3">Save Changes</button>
            </form>
        </div>
    </div>
@endsection
