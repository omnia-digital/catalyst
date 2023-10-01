<div
        @if ($eventClickEnabled)
            wire:click.stop="onEventClick('{{ $event['id'] }}')"
        @endif
        class="bg-neutral p-1 cursor-pointer {{ $extra['selectedID'] === $event['id'] ? 'ring-1' : '' }}">

    <div class="flex justify-between items-center font-bold" x-data x-tooltip="{{ $event['title'] }}">
        <p class="flex-1 text-2xs text-clip overflow-hidden whitespace-nowrap">
            {{ $event['title'] }}
        </p>
        <div class="items-center text-2xs hidden lg:flex">
            <x-heroicon-o-users class="w-3 h-3"/>
            <span>{{ $event['count'] }}</span>
        </div>
    </div>
</div>
