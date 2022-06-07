<div {{ $attributes->merge(['class' => 'bg-white p-2 flex items-center']) }}>
    <div class="rounded-full bg-gray-500 mr-4 p-2">
        <x-dynamic-component :component="$award->icon" class="h-4 w-4" />
    </div>
    <p class="whitespace-nowrap">{{ $award->name }}</p>
</div>