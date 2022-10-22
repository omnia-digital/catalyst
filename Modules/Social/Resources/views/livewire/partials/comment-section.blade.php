<div>
    <section aria-labelledby="activity-title" class="mt-4 xl:mt-6">
        <div>
            <div class="divide-y divide-neutral-light">
                {{--            <div class="pb-4">--}}
                {{--                <x-library::heading.2 id="activity-title" class="text-lg font-medium text-dark-text-color">Comments</x-library::heading.2>--}}
                {{--            </div>--}}
                <div>

                    <livewire:social::post-editor placeholder="Reply..."/>

                    <div class="mt-2 space-y-2">
                        @foreach($comments as $comment)
                            <livewire:social::components.post-card wire:key="comment-{{ $comment->id }}" :post="$comment"/>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <livewire:authentication-modal/>
</div>
