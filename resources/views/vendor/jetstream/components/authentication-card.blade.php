<div class="md:grid md:grid-cols-2 bg-neutral min-h-screen justify-center py-12 md:pt-0 md:px-4 xl:px-0">
    {{-- Left --}}
    <div class="flex flex-col md:items-end items-center md:min-h-screen md:pr-6 lg:pr-24 justify-center">
        <div class="flex flex-col">
            <div class="flex justify-center md:justify-start">
                {{ $logo ?? config('app.name') }}
            </div>

            <div class="text-center md:text-left md:items-start">
                {{ $slogan ?? config('app.slogan') }}
            </div>
        </div>
    </div>
    {{-- Right --}}
    <div class="md:flex md:flex-col md:items-start md:min-h-screen md:pl-6 lg:pl-24 mx-4 md:mx-0 justify-center">
        <div class="w-full md:max-w-md mt-6 px-6 py-4 bg-secondary shadow-md md:overflow-hidden md:rounded-lg">
            {{ $slot }}
        </div>

        @isset($additionalCard)
            <div class="w-full md:max-w-md mt-6 px-6 py-4 bg-secondary shadow-md overflow-hidden md:rounded-lg">
                {{ $additionalCard }}
            </div>
        @endisset
    </div>

</div>
