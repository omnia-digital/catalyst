<li>
    <button
        :id="$id('tab', whichChild($el.parentElement, $refs.tablist))"
        @click="select($el.id)"
        @focus="select($el.id)"
        type="button"
        :tabindex="isSelected($el.id) ? 0 : -1"
        :aria-selected="isSelected($el.id)"
        :class="isSelected($el.id) ? 'border-black bg-white' : 'border-transparent'"
        {{ $attributes->merge(['class' => 'inline-flex px-4 py-2 border-t border-l border-r rounded-t-md']) }}
        role="tab"
    >
        {{ $slot }}
    </button>
</li>
