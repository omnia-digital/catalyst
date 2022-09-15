<div class="sm:grid sm:grid-cols-2 bg-neutral min-h-screen justify-center py-12 sm:pt-0 sm:px-4 xl:px-0">
    {{-- Left --}}
    <div class="flex flex-col sm:items-end items-center sm:min-h-screen lg:pr-24 justify-center">
        <div class="flex flex-col">
            <div class="flex justify-center sm:justify-start">
                {{ $logo }}
            </div>

            <div class="text-center sm:text-left sm:items-start">
                {{ $slogan ?? config('app.slogan', '') }}
            </div>
        </div>
    </div>
    {{-- Right --}}
    <div class="sm:flex sm:flex-col sm:items-start sm:min-h-screen sm:pl-24 mx-4 sm:mx-0 justify-center">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-primary shadow-md sm:overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>

        @isset($additionalCard)
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-primary shadow-md overflow-hidden sm:rounded-lg">
                {{ $additionalCard }}
            </div>
        @endisset
    </div>

</div>
