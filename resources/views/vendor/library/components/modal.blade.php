@props([
    'hideCancelButton' => false,
    'cancelButtonText' => 'Cancel',
    'open' => false,
    'id' => uniqid(),
    'maxWidth'
])

@php
    $maxWidth = match($maxWidth ?? 'xl') {
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-3xl',
        '4xl' => 'sm:max-w-4xl',
        '5xl' => 'sm:max-w-5xl',
        '6xl' => 'sm:max-w-6xl',
        '7xl' => 'sm:max-w-7xl',
        default => 'sm:max-w-xl'
    };
@endphp

<div
        x-data="{
            open: '{{ $open }}' === 'true',
            closeModal: function() {
                this.open = false;

                Livewire?.emit('modal-closed', '{{ $id }}');
                $dispatch('modal-closed', '{{ $id }}');
            },
        }"
        x-init="() => {
            window.addEventListener('{{ $id }}', e => {
                const eventType = e.detail.type;
                if (eventType === 'close') {
                    closeModal();
                }
                else if (eventType === 'open') {
                    open = true;
                }
            });
        }"
        {{ $attributes->merge(['class' => 'flex justify-center']) }}
>
    <!-- Trigger -->
    {{ $trigger ?? null }}

    <!-- Modal -->
    <div
            x-show="open"
            x-on:keydown.escape.prevent.stop="closeModal"
            role="dialog"
            aria-modal="true"
            x-id="['modal-title']"
            :aria-labelledby="$id('modal-title')"
            class="fixed inset-0 overflow-y-auto"
            id="{{ $id }}"
            style="display: none"
    >
        <!-- Overlay -->
        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50"></div>

        <!-- Panel -->
        <div
                x-show="open"
                x-transition
                x-on:click="closeModal"
                class="relative min-h-screen flex items-center justify-center p-4"
        >
            <div
                    x-on:click.stop
                    x-trap.noscroll.inert="open"
                    class="relative {{ $maxWidth }} w-full bg-white border border-black rounded-lg shadow-lg p-12 overflow-y-auto"
            >
                <h2 class="text-3xl font-bold" :id="$id('modal-title')">
                    {{ $title }}
                </h2>

                {{ $content }}

                <div class="mt-8 flex space-x-2">
                    {{ $actions ?? null }}

                    @if ($hideCancelButton === false)
                        <button type="button" x-on:click="closeModal" class="bg-white border border-black rounded px-3 py-1.5">
                            {{ $cancelButtonText }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
