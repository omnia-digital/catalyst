@props([
    'icon' => 'menu-alt-4'
])
<li>
    <button 
        :id="$id('tab', whichChild($el.parentElement, $refs.tablist))"
        @click="select($el.id)"
        @mousedown.prevent
        @focus="select($el.id)"
        type="button"
        :tabindex="isSelected($el.id) ? 0 : -1"
        :class="isSelected($el.id) ? 'bg-gray-50 text-primary' : 'text-light-text-color'"
        {{ $attributes->merge(['class' => 'hover:bg-white group hover:text-neutral-dark rounded-md px-3 py-2 flex items-center']) }} 
        role="tab"
    >
        <x-dynamic-component 
            :component="'heroicon-o-'.$icon"
            :class="isSelected($el.parentElement.id) ? 'bg-gray-50 text-primary' : 'text-light-text-color'"
            class="group-hover:text-neutral-dark flex-shrink-0 -ml-1 mr-3 h-6 w-6" 
        />
        <span class="truncate">
            {{ $slot }}
        </span>
    </button>
</li>