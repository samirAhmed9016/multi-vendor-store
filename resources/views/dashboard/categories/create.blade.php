@extends('layout.dashboard')

@section('title', 'categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('contents')
    <div class="background-element"></div>
    <div class="container">
        <div class="form-container">
            <h2 class="mb-4 text-center">Create a New Category</h2>
            <form action="{{ route('dashboard.categories.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                {{-- Name --}}
                <div class="form-group">
                    {{-- <label for="name">Name</label> --}}
                    {{-- <input type="text" name="name" @class(['form-control', 'is-invalid' => $errors->has('name')]) id="name"
                        placeholder="Enter name" data-toggle="tooltip" data-placement="right"
                        title="Enter the name of the category." value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror --}}

                    <x-form.input class="form-control" type="text" name="name" label="Name" />
                </div>

        </div>

        {{-- Parent Category --}}
        <div class="form-group">
            <label for="parent_id">Parent Category</label>
            <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror" id="parent_id"
                data-toggle="tooltip" data-placement="right" title="Select a parent category if applicable.">
                <option value="">Primary Category</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
            @error('parent_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Description --}}
        <div class="form-group">
            {{-- <label for="Description">Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="Description"
                placeholder="Enter Description" data-toggle="tooltip" data-placement="right"
                title="Provide a brief description of the category.">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror --}}
            <x-form.textarea name="description" label="Description" value="{{ old('description') }}" />
        </div>

        {{-- Status --}}
        <div class="form-group">
            {{-- <label>Status</label> --}}
            <x-form.label id="image">Status</x-form.label>

            <x-form.radio name="status" :options="['active' => 'Active', 'archived' => 'Archived']" />
            {{-- <div class="form-check">
                <input type="radio" class="form-check-input @error('status') is-invalid @enderror" id="status_active"
                    name="status" value="active" {{ old('status') == 'active' ? 'checked' : '' }} data-toggle="tooltip"
                    data-placement="right" title="Set the category as active.">
                <label class="form-check-label" for="status_active">Active</label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input @error('status') is-invalid @enderror" id="status_archived"
                    name="status" value="archived" {{ old('status') == 'archived' ? 'checked' : '' }} data-toggle="tooltip"
                    data-placement="right" title="Set the category as archived.">
                <label class="form-check-label" for="status_archived">Archived</label>
            </div> --}}
            @error('status')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>

        {{-- Image --}}
        <div class="form-group">
            {{-- <label for="image">Image</label> --}}
            <x-form.label id="image">Image</x-form.label>
            <div class="custom-file">
                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image"
                    name="image" data-toggle="tooltip" data-placement="right"
                    title="Upload an image representing the category.">
                <label class="custom-file-label" for="image">Choose file</label>
                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </form>
    </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("image").files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>
@endsection
