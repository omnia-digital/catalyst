<section>
    <div class="shadow sm:overflow-hidden sm:rounded-md">
        <div class="bg-white py-6 px-4 sm:p-6">
            <div>
                <h2 class="text-lg font-medium leading-6 text-base-text-color">{{ $title }}</h2>
                @isset ($description)
                    <p class="mt-1 text-sm text-neutral-dark">{{ $description }}</p>
                @endisset
            </div>
            {{ $slot }}
        </div>
        @isset ($footer)
            <div class="flex items-center justify-end bg-neutral-light px-4 py-3 text-right sm:px-6">
                {{ $footer }}
            </div>
        @endisset
    </div>
</section>