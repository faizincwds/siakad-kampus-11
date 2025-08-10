{{-- Blade Only Component --}}
@props(['id', 'name', 'value' => '', 'options' => [], 'disabled' => false])

<select
    id="{{ $id }}"
    name="{{ $name }}"
    value="{{ $value }}"
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>

    @foreach ($options as $optionValue => $optionLabel)
        <option value="{{ $optionValue }}" {{ (string) $optionValue === (string) $value ? 'selected' : '' }}>
            {{ $optionLabel }}
        </option>
    @endforeach
</select>
