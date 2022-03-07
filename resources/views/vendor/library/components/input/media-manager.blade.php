@props([
    'file',
    'metadata' => [],
    'label' => 'Click to Upload Image',
    'setImageAction',
    'removeImageAction',
    'id'
])

<div
    x-data="{
        showMediaManager(file, metadata) {
            // Send data back to media manager to pre-fill data.
            this.$wire.emitTo(
                'media-manager',
                'media-manager:show',
                {
                    id: '{{ $id }}',
                    file: file,
                    metadata: metadata
                }
            );
        },
        setImage(event) {
            if (event.detail.id === '{{ $id }}') {
                this.$wire.call('{{ $setImageAction }}', event.detail);
            }
        }
    }"
    x-on:media-manager:file-selected.window="setImage"
>
    @if (empty($file))
        <button
            x-on:click.prevent="showMediaManager(null, {})"
            type="button"
            class="relative block w-full border-2 border-gray-300 border-dashed rounded-lg p-8 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
        >
{{--            <x-coolicon-image class="mx-auto h-8 w-8 text-gray-400"/>--}}
            <span class="mt-2 block text-sm font-medium text-gray-500">
            {{ $label }}
        </span>
        </button>
    @else
        <div class="relative">
            <button
                wire:click.prevent="{{ $removeImageAction }}"
                type="button"
                class="absolute -top-2 -right-2 z-10 bg-red-100 rounded-full p-1 inline-flex items-center justify-center hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500"
            >
                <x-heroicon-o-x class="w-5 h-5 text-red-500 hover:text-red-400"/>
            </button>

            <div
                x-on:click.prevent="showMediaManager('{{ $file }}', {{ Illuminate\Support\Js::from($metadata) }})"
                class="block w-full aspect-w-10 aspect-h-7 rounded-lg overflow-hidden cursor-pointer"
            >
                <img src="{{ $file }}" alt="" class="object-cover">
            </div>
        </div>
    @endif
</div>
