<div class="col-span-1 bg-primary rounded-lg shadow max-h-68">
    <!-- Content -->
    <div class="w-full">
        <div class="space-y-2 py-4 px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 align-middle">
                    <h4 class="flex items-center">
                        <a href="{{ route('resources.show', ['resource' => $post]) }}">{{ $post->title }}</a>
                    </h4>

                    @empty(!$post->is_verified)
                        <x-heroicon-o-check-circle class="flex-shrink-0 w-6 h-6 inline-block  text-green-700 text-xs font-medium rounded-full"/>
                    @endempty

                    <h4 class="text-base-text-color text-md font-normal">{{ $post->created_at->diffInDays() < 2 ? $post->created_at->shortAbsoluteDiffForHumans() : $post->created_at->format('M d')
                    }}</h4>
                </div>

                @if ($post->tags)
                    <div class="flex justify-start space-x-2">
                        @foreach($post->tags as $tag)
                            <x-library::tag class="bg-neutral-light">{{ $tag }}</x-library::tag>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="w-full">
                {!! Purify::clean($post->body) !!}
            </div>

            @if($post->image)
                <div class="block w-full aspect-w-10 aspect-h-3 rounded-lg overflow-hidden">
                    <img src="{{ $post->image }}" alt="{{ $post->title }}" class="object-cover">
                </div>
            @endif
        </div>
    </div>

    <!-- Social Actions -->
    <div class="px-6">
        <livewire:social::partials.post-actions :post="$post"/>
    </div>
</div>
