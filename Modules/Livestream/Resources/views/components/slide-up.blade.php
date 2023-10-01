@props([
    'show' => false,
    'eventSlideUpClosed' => 'slide-up-closed'
])

<div
        x-data="{
        show: '{{ $show }}',
        dock: false,

        toggleDock() {
            if(this.dock === true) {
                this.dock = false
                return
            }
            this.dock = true
        }
    }"
        x-show="show"
        x-on:show-slide-up.window="show = true"
        x-on:hide-slide-up.window="show = false"
        {{ $attributes->merge(['class' => 'fixed bottom-0 left-0 right-0 h-72 z-30 transform transition-all ease-in-out duration-500 sm:duration-700']) }}
        aria-labelledby="slide-up-title" role="dialog" aria-modal="true"
        style="display: none;"
        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
        x-transition:enter-start="translate-y-full"
        x-transition:enter-end="translate-y-0"
        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
        x-transition:leave-start="translate-y-0"
        x-transition:leave-end="translate-y-full"
        :class="dock ? 'translate-y-3/4' : 'translate-y-0'"
>
    <div
            class="w-screen h-full"
    >
        <div class="h-full flex flex-col py-6 bg-white shadow-xl">
            <div class="px-4 sm:px-6">
                <div class="flex items-start justify-between">
                    @if (isset($title))
                        <h2 class="text-lg font-medium text-gray-900" id="slide-up-title">
                            {{ $title }}
                        </h2>
                    @endif

                    <div class="{{ isset($title) ? 'ml-3' : '' }} h-7 flex items-center">
                        <button
                                title="Hide"
                                x-on:click="toggleDock"
                                class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            <span class="sr-only">Hide panel</span>
                            <x-heroicon-o-chevron-down x-show="!dock" class="h-6 w-6"/>
                            <x-heroicon-o-chevron-up x-show="dock" class="h-6 w-6"/>
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-1 relative flex-1 px-4 sm:px-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
