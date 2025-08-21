{{-- @extends('layout.dashboard')

@section('title', 'roles')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Roles</li>
@endsection

@section('contents')

    <div class="container">
        <div class="form-container">
            <h2 class="mb-4 text-center">Create a New Role</h2>

            <form action="{{ route('roles.store') }}" method="post">
                @csrf


                <div class="form-group">
                    <x-form.input class="form-control" type="text" name="name" label="Role Name" />
                </div>

                <fieldset>
                    <legend>{{ __('Abilities') }}</legend>

                    @foreach (config('abilities') as $ability_code => $ability_name)
                        <div class="row mb-2">
                            <div class="col-md-6">
                                {{ $ability_name }}
                            </div>
                            <div class="col-md-2">
                                <input type="radio" name="ability" name="abilities[{{ $ability_code }}]" value="allow">
                                Allow
                            </div>
                            <div class="col-md-2">
                                <input type="radio" name="ability" name="abilities[{{ $ability_code }}]" value="deny">
                                Deny
                            </div>
                            <div class="col-md-2">
                                <input type="radio" name="ability" name="abilities[{{ $ability_code }}]" value="inherit">
                                Inherit
                            </div>
                    @endforeach


                </fieldset>


                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
    </div>
@endsection --}}





















@extends('layout.dashboard')

@section('title', 'roles')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Roles</li>
@endsection

@section('contents')
    <div class="container">
        <div class="form-container">
            <h2 class="mb-4 text-center">Create a New Role</h2>

            <form action="{{ route('dashboard.roles.store') }}" method="post">
                @csrf


                <div class="form-group mb-4">
                    <x-form.input class="form-control" type="text" name="name" label="Role Name" />
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
                                        <input type="radio" name="abilities[{{ $ability_code }}]" value="allow" checked>
                                    </td>
                                    <td class="text-center">
                                        <input type="radio" name="abilities[{{ $ability_code }}]" value="deny">
                                    </td>
                                    <td class="text-center">
                                        <input type="radio" name="abilities[{{ $ability_code }}]" value="inherit">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </fieldset>

                <button type="submit" class="btn btn-primary btn-block mt-3">Submit</button>
            </form>
        </div>
    </div>
@endsection
