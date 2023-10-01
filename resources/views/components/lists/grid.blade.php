@props([
    'items',
    'selectedItem'
])
<ul role="list" class="grid grid-cols-6 gap-1">
    @foreach ($items as $item)
        <x-lists.grid-item
                wire:key="item-{{ $item->id }}"
                wire:click="selectItem({{ $item->id }})"
                :item="$item"
                {{--            :selected="$item->id === $selectedItem"--}}
        />
    @endforeach
</ul>
