@props([
    'heading',
    'description' => null
])

<div {{ $attributes->merge(['class' => 'bg-post-card-bg-color shadow overflow-hidden sm:rounded-lg']) }}>
    @if (isset($heading) || isset($description) || isset($actions))
        <div class="px-4 py-5 sm:px-6 -ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
            <div class="ml-4 mt-2">
                @isset($heading)
                    <h3 class="text-base leading-6 font-medium text-dark-text-color">
                        {{ $heading }}
                    </h3>
                @endisset

                @isset ($description)
                    <p class="mt-1 max-w-2xl text-sm text-base-text-color">
                        {{ $description }}
                    </p>
                @endisset
            </div>
            @if (isset($actions))
                <div class="ml-4 mt-2 flex-shrink-0">
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif
    <div class="">
        {{ $slot }}
    </div>
</div>
