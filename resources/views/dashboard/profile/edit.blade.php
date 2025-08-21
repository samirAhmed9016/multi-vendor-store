@extends('layout.dashboard')

@section('title', 'Edit Profile')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Profile</li>
@endsection

@section('contents')
    <div class="background-element"></div>
    <div class="container">
        <div class="form-container">
            <h2 class="mb-4 text-center">Edit Profile</h2>
            <form action="{{ route('dashboard.profile.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="form-row">
                    <div class="col-md-6">
                        <x-form.input name="first_name" label="First Name" :value="$user->profile->first_name" />
                    </div>

                    <div class="col-md-6">
                        <x-form.input name="last_name" label="Last Name" :value="$user->profile->last_name" />
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <x-form.input type="date" name="birthday" label="Birthday" :value="$user->profile->birthday" />
                    </div>
                </div>




                <!-- Gender -->
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" class="form-control">
                        <option value="">Select Gender</option>
                        <option value="male" {{ $user->profile->gender == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ $user->profile->gender == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>




                <div class="form-group">
                    <x-form.input name="street_address" label="Street Address" :value="$user->profile->street_address" />
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <x-form.input name="city" label="City" :value="$user->profile->city" />
                    </div>

                    <div class="col-md-6">
                        <x-form.input name="state" label="State" :value="$user->profile->state" />
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <x-form.input name="postal_code" label="Postal Code" :value="$user->profile->postal_code" />
                    </div>

                </div>

                <!-- Country -->
                <div class="form-group">
                    <label for="country">Country</label>
                    <select name="country" class="form-control" required>
                        @foreach ($countries as $code => $name)
                            <option value="{{ $code }}" {{ $user->profile->country == $code ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('country')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Locale -->
                <div class="form-group">
                    <label for="locale">Locale</label>
                    <select name="locale" class="form-control" required>
                        @foreach ($locales as $code => $name)
                            <option value="{{ $code }}" {{ $user->profile->locale == $code ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('locale')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
@endsection
