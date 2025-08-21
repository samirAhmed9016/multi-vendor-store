{{-- @props(['name', 'options', 'checked' => false]) --}}
@props(['name' => 'status', 'options' => []])



{{-- @foreach ($options as $value => $text)
    <div class="form-check">
        <input type="radio" id="status_active" name="{{ $name }}" value="{{ $value }}"
            @checked(old($name, $checked == $value))
            {{ $attributes->class(['form-check-input', 'is-invalid' => $errors->has($name)]) }} data-toggle="tooltip"
            data-placement="right" title="Set the category as active.">
        <label class="form-check-label" for="status_active">Active</label>
        {{ $text }}
    </div>
@endforeach --}}
@foreach ($options as $value => $label)
    <div class="form-check">
        <input type="radio" class="form-check-input @error($name) is-invalid @enderror"
            id="{{ $name }}_{{ $value }}" name="{{ $name }}" value="{{ $value }}"
            {{ old($name, '') == $value ? 'checked' : '' }} data-toggle="tooltip" data-placement="right"
            title="Set the category as {{ strtolower($label) }}.">
        <label class="form-check-label" for="{{ $name }}_{{ $value }}">{{ $label }}</label>
    </div>
@endforeach
