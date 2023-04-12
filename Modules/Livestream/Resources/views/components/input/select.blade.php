@props([
    'placeholder' => 'Please select an item',
    'options' => [],
    'default' => '',
    'enableDefaultOption' => false
])
<select {{ $attributes->merge(['class' => 'block focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm border-gray-300 rounded-md']) }}>
    <option value="{{ $default }}" {{ $enableDefaultOption === false ? 'disabled selected' : '' }}>{{ $placeholder }}</option>

    @foreach ($options as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
</select>
