@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-secondary-light focus:ring focus:ring-secondary-light focus:ring-opacity-50 rounded-md shadow-sm']) !!}>
