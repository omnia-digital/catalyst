<div class="grid grid-cols-2 bg-neutral">
    {{-- Left --}}
    <div class="flex flex-col items-end min-h-screen pr-24 justify-center">
        <div class="flex flex-col">
            <div>
                {{ $logo }}
            </div>

            <div>
                {{ $slogan ?? config('app.slogan', '') }}
            </div>
        </div>
    </div>
    {{-- Right --}}
    <div class="flex flex-col items-start min-h-screen pl-24 justify-center">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-primary shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>

        @isset($additionalCard)
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-primary shadow-md overflow-hidden sm:rounded-lg">
                {{ $additionalCard }}
            </div>
        @endisset
    </div>

</div>
