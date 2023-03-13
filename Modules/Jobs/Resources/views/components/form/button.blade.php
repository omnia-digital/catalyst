@props(['type' => 'submit'])

<button wire:loading.attr="disabled"
        wire:loading.class.remove="bg-light-blue-500 hover:bg-light-blue-600 focus:border-light-blue-700 focus:shadow-outline-light-blue active:bg-light-blue-700"
        wire:loading.class="bg-gray-500 cursor-not-allowed"
        type="{{ $type }}"
        {{ $attributes->merge(['class' => 'bg-light-blue-500 border border-transparent rounded-md py-2 px-4 inline-flex justify-center text-sm leading-5 font-medium text-white hover:bg-light-blue-600 focus:outline-none focus:border-light-blue-700 focus:shadow-outline-light-blue active:bg-light-blue-700 transition duration-150 ease-in-out']) }}
>
    <div>
        <span wire:loading {{ $attributes->only('wire:target') }}>Loading...</span>
        <span wire:loading.remove {{ $attributes->only('wire:target') }}>{{ $slot ?? 'Submit' }}</span>
    </div>
</button>
