<div
    @if($eventClickEnabled)
        wire:click.stop="onEventClick('{{ $event['id']  }}')"
    @endif
    class="bg-neutral p-1 cursor-pointer {{ $extra['selectedID'] === $event['id'] ? 'ring-1' : '' }}">

    <div class="flex justify-between items-center font-bold">
        <p class="flex-1 text-xxs">
            {{ $event['title'] }}
        </p>
        <div class="flex items-center text-xxs">
            <x-heroicon-o-users class="w-3 h-3" />
            <span>{{ $event['count'] }}</span>
        </div>
    </div>
</div>