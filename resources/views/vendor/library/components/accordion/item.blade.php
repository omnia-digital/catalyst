@props([
    'id' => uniqid()
])

<div
    x-data="{
        id: '{{ $id }}',
        get expanded() {
            return this.active === this.id
        },
        set expanded(value) {
            this.active = value ? this.id : null
        },
    }"
    role="region"
    {{ $attributes->merge(['class' => 'border border-black rounded-md shadow']) }}
>
    <x-library::heading.2>
        <button
                x-on:click="expanded = !expanded"
                :aria-expanded="expanded"
                class="flex items-center justify-between w-full font-bold text-xl px-6 py-3"
        >
            <span>{{ $title }}</span>
            <span x-show="expanded" aria-hidden="true" class="ml-4">&minus;</span>
            <span x-show="!expanded" aria-hidden="true" class="ml-4">&plus;</span>
        </button>
    </x-library::heading.2>

    <div x-show="expanded" x-collapse>
        <div class="pb-4 px-6">
            {{ $content }}
        </div>
    </div>
</div>
