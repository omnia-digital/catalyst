<div {{ $attributes
    ->class(['shadow-md ring-1 ring-neutral-dark' => $selectedItem])
    ->merge([
        'class' => 'space-y-2 mx-2 p-4 bg-primary rounded-lg border border-neutral cursor-pointer hover:shadow-lg hover:ring-2 hover:ring-neutral-dark active:shadow-lg active:ring-2 active:ring-neutral-dark focus:shadow-lg focus:ring-2 focus:ring-neutral-dark'
    ]) }}
>
    @isset($item->name)
    <div class="flex justify-between">
        <p class="text-dark-text-color font-semibold text-base">{{ $item->name }}</p>
    </div>
    @endisset
    @isset($item->location)
        <div class="flex items-center text-base-text-color">
            <x-heroicon-o-location-marker class="h-4 w-4 mr-2" />
            <span class="text-dark-text-color text-xs">{{ $item->location }}</span>
        </div>
    @endisset
    @if ($item->summary)
        <p class="text-light-text-color text-xs line-clamp-3">{{ $item->summary }}</p>
    @endif
    <div class="flex items-center space-x-4">
        @if ($item->users_count)
            <div class="flex items-center">
                <x-heroicon-o-users class="h-4 w-4 mr-2" />
                <p>{{ $item->users_count }}</p>
            </div>
        @endif
        @if ($item->getEventDate())
            <div class="flex items-center">
                <x-heroicon-o-calendar class="h-4 w-4 mr-2" />
                <p>{{ $item->getEventDate()->toFormattedDateString() }}</p>
            </div>
        @endif
    </div>
</div>