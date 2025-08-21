{{-- <select name="{{ $name }}"
    {{ $attributes->class(['form-control', 'form-select', 'is-invalid' => $errors->has($name)]) }}
    @foreach ($options as $value => $text)
<option value="{{ $value }}" @selected($value == $selected)>{{ $text }}</option> @endforeach
    </select> --}}


@props(['name', 'options' => [], 'selected' => null, 'placeholder' => null])

@php
    $selectedValue = old($name, $selected);
    if (is_array($selectedValue)) {
        $selectedValue = '';
    }
@endphp

<select name="{{ $name }}"
    {{ $attributes->class(['form-control', 'form-select', 'is-invalid' => $errors->has($name)]) }}>
    @if ($placeholder)
        <option value="" disabled @selected(empty($selectedValue))>{{ $placeholder }}</option>
    @endif

    @foreach ($options as $value => $text)
        <option value="{{ $value }}" @selected($value == $selectedValue)>
            {{ $text }}
        </option>
    @endforeach
</select>
