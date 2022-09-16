@props([
    'wordCountType' => 'word', // word or character
    'characterLimit' => null,
    'heightClass' => 'tiptap-height-full',
    'placeholderClass' => 'is-editor-empty',
    'placeholder' => 'Write something...',
    'class' => '',
])

<div class="editor bg-primary shadow-sm {{ $class }}">
    <div
            wire:ignore
            x-data="{
                content: @entangle($attributes->wire('model')),
                wordCount: 0,
                wordCountType: '{{ $wordCountType }}',
                characterLimit: '{{ $characterLimit }}',
                heightClass: '{{ $heightClass }}',
                placeholderClass: '{{ $placeholderClass }}',
                placeholderText: '{{ $placeholder }}',
                ...tiptap()
            }"
    >
        <x-library::tiptap.menu/>

        <div x-ref="editorReference" {{ $attributes->whereDoesntStartWith('wire:model') }}></div>

        <div>
            {{ $footer ?? null }}
        </div>

        <!-- Modals -->
        <x-library::tiptap.link-modal/>
    </div>
</div>

@once
    @push('scripts')
        <script src="{{ asset('/vendor/library/tiptap.js') }}"></script>
    @endpush
@endonce
