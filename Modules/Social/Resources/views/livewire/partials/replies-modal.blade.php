<div class="inline-flex items-center text-sm" x-data x-on:click.stop="">
    @auth
        <button
                type="button"
                class="inline-flex space-x-2 text-gray-400 hover:text-gray-500"
                x-data
                x-on:click.prevent.stop="$openModal('comment-modal-{{ $post->id }}')"
        >
            <x-heroicon-o-chat-alt :class="$show ? 'h-6 w-6' : 'h-5 w-5'" aria-hidden="true"/>
            <span class="font-medium text-gray-900">{{ $replyCount > 0 ? $replyCount : '' }}</span>
            <span class="sr-only">replies</span>
        </button>
    @else
        <button
                type="button"
                class="inline-flex space-x-2 text-gray-400 hover:text-gray-500"
                wire:click.prevent.stop="showLoginModal('{{ route('social.posts.show', $post) }}')"
        >
            <x-heroicon-o-chat-alt :class="$show ? 'h-6 w-6' : 'h-5 w-5'" aria-hidden="true"/>
            <span class="font-medium text-gray-900">{{ $replyCount > 0 ? $replyCount : '' }}</span>
            <span class="sr-only">replies</span>
        </button>
    @endauth
    {{--@once--}}
    <x-library::modal id="comment-modal-{{ $post->id }}" maxWidth="4xl" hideCancelButton>
        <x-slot name="title">Comment</x-slot>
        <x-slot name="content">
            <livewire:social::post-editor wire:key="comment-editor-{{ $post->id }}" editorId="comment-editor-{{ $post->id }}"/>
        </x-slot>
    </x-library::modal>
    {{--@endonce--}}
</div>
