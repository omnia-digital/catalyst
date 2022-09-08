@props([
    'default' => 1
])

<div
        x-data="{
            selectedId: null,
            init() {
                // Set the first available tab on the page on page load.
                this.$nextTick(() => this.select(this.$id('tab', '{{ $default }}')))
            },
            select(id) {
                this.selectedId = id
            },
            isSelected(id) {
                return this.selectedId === id
            },
            whichChild(el, parent) {
                return Array.from(parent.children).indexOf(el) + 1
            }
        }"
        x-id="['tab']"
        class="max-w-3xl bg-neutral"
>
    <ul
            x-ref="tablist"
            @keydown.right.prevent.stop="$focus.wrap().next()"
            @keydown.home.prevent.stop="$focus.first()"
            @keydown.page-up.prevent.stop="$focus.first()"
            @keydown.left.prevent.stop="$focus.wrap().prev()"
            @keydown.end.prevent.stop="$focus.last()"
            @keydown.page-down.prevent.stop="$focus.last()"
            role="tablist"
            class="-mb-px flex items-stretch"
    >
        {{ $items }}
    </ul>

    <div role="tabpanels" class="border border-black rounded-b-md">
        {{ $panels }}
    </div>
</div>
