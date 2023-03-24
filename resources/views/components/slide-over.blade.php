@props([
    'show' => false,
    'eventSlideOverClosed' => 'slide-over-closed',
    'disableCloseOnClickAway' => false
])

<div
    x-data="{
        show: '{{ $show }}',

        closeOnClickAway: '{{ !$disableCloseOnClickAway }}',

        closeSlideOver(isClickedAway = false) {
            // Don't close if disableCloseOnClickAway prop is true
            if (isClickedAway === true && this.closeOnClickAway != true)  {
                return;
            }

            this.show = false;

            this.$wire.emit('{{ $eventSlideOverClosed }}')
        }
    }"
    x-show="show"
    x-on:show-slide-over.window="show = true"
    x-on:hide-slide-over.window="closeSlideOver"
    {{ $attributes->merge(['class' => 'fixed inset-0 overflow-hidden z-[70]']) }}
    aria-labelledby="slide-over-title" role="dialog" aria-modal="true"
    style="display: none;"
>
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute inset-0" aria-hidden="true"></div>

        <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
            <div
                x-show="show"
                x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                x-on:click.away="closeSlideOver(true)"
                class="w-screen max-w-md"
            >
                <div class="h-full flex flex-col py-6 bg-white shadow-xl overflow-y-scroll overscroll-none">
                    <div class="px-4 sm:px-6">
                        <div class="flex items-start justify-between">
                            @if (isset($title))
                                <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">
                                    {{ $title }}
                                </h2>
                            @endif

                            <div class="{{ isset($title) ? 'ml-3' : '' }} h-7 flex items-center">
                                <button
                                    x-on:click="closeSlideOver"
                                    class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    <span class="sr-only">Close panel</span>
                                    <x-heroicon-o-x class="h-6 w-6"/>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 relative flex-1 px-4 sm:px-6">
                        <div class="absolute inset-0 px-4 sm:px-6">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
