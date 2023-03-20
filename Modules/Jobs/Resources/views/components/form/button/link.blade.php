@props([
'href'
])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'bg-red-600 rounded-md py-2 px-4 inline-flex justify-center text-sm leading-5 font-medium
text-white focus:shadow-outline-red active:bg-red-700 transition duration-150 ease-in-out']) }}>
    {{ $slot }}
</a>
