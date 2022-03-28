<section aria-labelledby="activity-title" class="mt-4 xl:mt-6">
    <div>
        <div class="divide-y divide-neutral-light">
            <div class="pb-4">
                <h2 id="activity-title" class="text-lg font-medium text-gray-900">Comments</h2>
            </div>
            <div class="pt-6">
                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=8&amp;w=256&amp;h=256&amp;q=80" alt="">
                    </div>
                    <div class="min-w-0 flex-1">
                        <livewire:social::post-editor/>
                    </div>
                </div>

                <div class="mt-4">
                    @foreach($comments as $comment)
                        <x-social::post.card wire:key="comment-{{ $comment->id }}" :post="$comment"/>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
