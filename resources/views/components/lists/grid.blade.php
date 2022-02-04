<ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6  md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 xl:gap-x-8">
    @foreach($items as $item)
        <x-lists.grid-item
            wire:key="item-{{ $item->id }}"
            wire:click="selectItem({{ $item->id }})"
            :item="$item"
            :selected="$item->id === $selectedItem"
        />
    @endforeach
</ul>
