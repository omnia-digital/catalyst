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
    class="h-full"
>
    <section class="mx-auto max-w-7xl pb-10 lg:py-12 lg:px-8">
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
            <aside class="py-6 px-2 sm:px-6 lg:col-span-3 lg:py-0 lg:px-0">
                <ul 
                    x-ref="tablist"
                    @keydown.right.prevent.stop="$focus.wrap().next()"
                    @keydown.home.prevent.stop="$focus.first()"
                    @keydown.page-up.prevent.stop="$focus.first()"
                    @keydown.left.prevent.stop="$focus.wrap().prev()"
                    @keydown.end.prevent.stop="$focus.last()"
                    @keydown.page-down.prevent.stop="$focus.last()"
                    role="tablist"
                    class="space-y-1"
                >
                    {{ $items }}
                </ul>
            </aside>

            <div role="tabpanels" class="space-y-6 sm:px-6 lg:col-span-9 lg:px-0">
                {{ $panels }}
            </div>
        </div>
    </section>
</div>