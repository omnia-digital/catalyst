@props([
'submit',
'id' => uniqid()
])

<div
    x-data="{show: false}"
    x-trap="show"
    x-init="() => {
        window.addEventListener('{{ $id }}', e => {
            const eventType = e.detail.type;

            if (eventType === 'hide') {
                show = false;
            }
            else if (eventType === 'show') {
                show = true;
            }
        });
    }"
    {{ $attributes->only('class') }}
>
    {{ $trigger ?? null }}

    <div x-show="show" class="fixed z-50 inset-0 overflow-hidden flex items-center justify-center w-full h-full p-4" style="display: none;">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
        </div>

        <div
            x-on:click.away="show = false"
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="flex mx-auto transition-all transform bg-white dark:bg-mirage-900 rounded-lg shadow-xl max-h-full sm:w-full px-4 sm:px-6 pt-4 sm:pt-6 sm:max-w-lg"
        >
            <form wire:submit.prevent="{{ $submit }}" class="max-h-full flex-1 overflow-y-auto flex flex-col sm:flex-row">
                <div class="absolute top-0 right-0 pt-4 pr-4">
                    <button x-on:click="show = false" type="button" class="text-gray-400 bg-white rounded-md dark:bg-mirage-900 dark:text-white focus:outline-none" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto rounded-full sm:mx-0 sm:h-10 sm:w-10 mb-4 sm:mb-0 text-red-600 bg-red-100">
                    @if (isset($icon))
                        {{ $icon }}
                    @else
                        <x-heroicon-o-exclamation class="w-6 h-6 text-red-600"/>
                    @endif
                </div>

                <div class="max-h-full sm:ml-4 flex-1">
                    <header class="text-center sm:text-left mb-2">
                        <h3 class="text-lg font-bold leading-6 text-gray-900 dark:text-white">
                            {{ $title }}
                        </h3>
                    </header>
                    <div class="max-h-full">
                        <p class="text-center sm:text-left">{{ $content ?? 'Are you sure to run this action?' }}</p>
                    </div>
                    <div class="mt-5 sm:mt-4 mb-4 sm:mb-6 sm:flex">
                        <div class="flex items-center justify-center w-full space-x-2 sm:justify-end px-1">
                            <button x-on:click="show = false" type="button" class="inline-flex items-center px-3 py-2 border-gray-300 bg-white hover:bg-gray-50 focus:ring-red-500 dark:bg-mirage-800 dark:border-mirage-500 dark:hover:bg-mirage-900 dark:hover:border-mirage-600 border border-transparent rounded cursor-pointer shadow-sm hover:shadow-lg transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-mirage-500">
                                Cancel
                            </button>
                            <x-form.button-destruction type="submit">Confirm</x-form.button-destruction>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
