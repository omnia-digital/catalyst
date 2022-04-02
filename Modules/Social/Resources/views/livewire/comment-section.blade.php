<section aria-labelledby="activity-title" class="mt-4 xl:mt-6">
    <div>
        <div class="divide-y divide-neutral-light">
            <div class="pb-4">
                <h2 id="activity-title" class="text-lg font-medium text-dark-text-color">Comments</h2>
            </div>
            <div class="pt-6">

                        <livewire:social::post-editor placeholder="Reply..."/>

                <div class="mt-4">
                    @foreach($comments as $comment)
                        <x-social::post.card wire:key="comment-{{ $comment->id }}" :post="$comment"/>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
