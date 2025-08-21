@props(['type' => 'text', 'name', 'label' => false])



@if ($label)
    <label for="{{ $name }}">{{ $label }}</label>
@endif

<input type="{{ $type }}" name="{{ $name }}"
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }} {{-- @class(['form-control', 'is-invalid' => $errors->has($name)])  --}} id="name"
    placeholder="Enter name" data-toggle="tooltip" data-placement="right" title="Enter the name of the category."
    value="{{ old($name) }}">
@error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
