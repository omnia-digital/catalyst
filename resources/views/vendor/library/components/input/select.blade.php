@props([
'options' => [],
'placeholder' => 'Select an option'
])

<select {{ $attributes->merge(['class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm']) }}>
    <option value="" disabled selected>{{ $placeholder }}</option>

    @foreach ($options as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
</select>
