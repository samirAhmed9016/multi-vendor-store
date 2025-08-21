@props(['name', 'label' => false, 'value' => ''])

@if ($label)
    <label for="{{ $name }}">{{ $label }}</label>
@endif

<textarea name="{{ $name }}" id="{{ $name }}" placeholder="Enter Description" data-toggle="tooltip"
    data-placement="right" title="Enter the name of the category."
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}>{{ old($name, $value) }}
</textarea>

@error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
