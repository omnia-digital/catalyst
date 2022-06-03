<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-neutral">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-primary shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>

    @isset($additionalCard)
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-primary shadow-md overflow-hidden sm:rounded-lg">
            {{ $additionalCard }}
        </div>
    @endisset
</div>
