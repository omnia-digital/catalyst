<div class="col-span-1 bg-white rounded-lg shadow max-h-68">
    <!-- Content -->
    <div class="w-full">
        <div class="space-y-2 py-4 px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <h3 class="text-gray-900 text-2xl hover:underline font-bold">
                        <a href="{{ route('resources.show', ['resource' => $post]) }}">{{ $post->title }}</a>
                    </h3>

                    @empty(!$post->is_verified)
                        <x-heroicon-o-check-circle class="flex-shrink-0 w-6 h-6 inline-block  text-green-700 text-xs font-medium rounded-full"/>
                    @endempty
                </div>

                @if ($post->tags)
                    <div class="flex justify-start space-x-2">
                        @foreach($post->tags as $tag)
                            <x-library::tag class="bg-gray-200">{{ $tag }}</x-library::tag>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex justify-start">
                <x-heroicon-o-calendar class="w-5 h-5"/>
                <p class="ml-2 text-gray-500 text-md truncate">{{ $post->created_at->format('M d, Y') }}</p>
            </div>

            <div class="w-full">
                {!! Purify::clean($post->body) !!}
            </div>

            <div class="block w-full aspect-w-10 aspect-h-3 rounded-lg overflow-hidden">
                <img src="{{ $post->image }}" alt="{{ $post->title }}" class="object-cover">
            </div>
        </div>
    </div>

    <!-- Social Actions -->
    <div class="px-6">
        <livewire:social::partials.post-actions :post="$post"/>
    </div>
</div>
