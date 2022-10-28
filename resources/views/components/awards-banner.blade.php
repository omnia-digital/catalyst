<div {{ $attributes->merge(['class' => 'bg-white p-2 flex items-center']) }}>
    <div class="rounded-full bg-gray-500 mr-4 p-2">
        <x-library::icons.icon :name="$award->icon" class="h-4 w-4"/>
    </div>
    <p>{{ ucfirst($award->name) }}</p>
</div>
