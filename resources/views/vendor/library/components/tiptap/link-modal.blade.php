@php
    $options = [
        '_blank' => 'Blank',
        '_self' => 'Self (Default)',
        '_parent' => 'Parent',
        '_top' => 'Top',
        'framename' => 'Frame Name'
    ];
@endphp

<div
    x-data="{
        url: null,
        target: '_self',
        rel: null,
        error: null,
        insertLink() {
            this.error = null;

            if (!this.url) {
                this.error = 'Please add an URL.';
                return;
            }

            if (!editor().view.state.selection.empty) {
                let insertedDomain = new URL(this.url).hostname;
                let domain = window.libraryConfig.domain;
                let rel = null;

                if (insertedDomain === domain) {
                    rel = this.rel;
                }
                else {
                    rel = this.rel ? this.rel : window.libraryConfig.external_links_rel.join(' ');
                }

                editor().commands.setLink({ href: this.url, target: this.target, rel: rel })
            }

            $dispatch('link-modal', {type: 'close'});

            // Reset data
            this.url = null;
            this.target = '_self';
            this.rel = null;
        },
        removeLink() {
            editor().commands.unsetLink();

            $dispatch('link-modal', {type: 'close'});
        },
        setLinkData(data) {
            this.url = data.href;
            this.target = data.target;
            this.rel = data.rel;
        }
    }"
    x-on:link-data.window="setLinkData(event.detail)"
    x-on:keydown.enter.prevent="insertLink"
    {{ $attributes }}
>
    <x-library::modal id="link-modal" hideCancelButton>
        <x-slot name="title">Insert Link</x-slot>
        <x-slot name="content">
            <div class="mt-6 space-y-4">
                <div>
                    <x-library::input.label value="URL"/>
                    <x-library::input.text x-on:link-modal.window="setTimeout(() => $el.focus(), 250)" x-model="url" id="url" placeholder="URL"/>
                    <p x-show="error" x-text="error" class="text-sm text-red-600 mt-1"></p>
                </div>
                <div>
                    <x-library::input.label value="Target"/>
                    <x-library::input.select x-model="target" :options="$options" placeholder="Target" id="target"/>
                </div>
                <div>
                    <x-library::input.label value="Rel"/>
                    <x-library::input.text x-model="rel" id="rel" placeholder="Rel"/>
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-library::button x-show="isActive('link', updatedAt)" x-on:click="removeLink" secondary>Remove Link</x-library::button>
            <x-library::button x-on:click.prevent="insertLink">Insert</x-library::button>
        </x-slot>
    </x-library::modal>
</div>
