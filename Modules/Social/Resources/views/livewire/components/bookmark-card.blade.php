<div class="col-span-1 bg-primary rounded-lg shadow">
    <!-- Content -->
    <div class="w-full flex justify-between">
        <img class="rounded-tl-lg rounded-br-lg h-full object-contain w-1/3 bg-neutral-dark flex-shrink-0"
             src="{{$post->main_image}}" alt="">
        <div class="flex-1 space-y-2 py-4 px-6">
            <div class="flex items-center space-x-3">
                <h3 class="text-gray-900 text-2xl font-bold truncate">{{ $post->title }}</h3>
                @empty(!$post->is_verified)
                    <x-heroicon-o-check-circle class="flex-shrink-0 w-6 h-6 inline-block  text-green-700 text-xs font-medium rounded-full"/>
                @endempty
            </div>
            <div class="flex justify-start">
                <x-heroicon-o-calendar class="w-5 h-5"/>
                <p class="ml-2 text-gray-500 text-md truncate">{{ $post->created_at->format('M d, Y') }}</p>
            </div>
            @empty(!$post->tags)
                <div class="flex justify-start space-x-2">
                    @foreach($post->tags as $tag)
                        <x-library::tag>{{ $tag }}</x-library::tag>
                    @endforeach
                </div>
            @endempty
            <div class="w-full">
                {{ $post->body }}
            </div>
        </div>
    </div>

    <!-- Social Actions -->
    <div>
        <div class="-mt-px flex">
            <div class="w-0 flex-1 flex">
                <a href="mailto:janecooper@example.com"
                   class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                    <!-- Heroicon name: solid/mail -->
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                    <span class="ml-3">Email</span>
                </a>
            </div>
            <div class="-ml-px w-0 flex-1 flex">
                <a href="tel:+1-202-555-0170"
                   class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                    <!-- Heroicon name: solid/phone -->
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                    </svg>
                    <span class="ml-3">Call</span>
                </a>
            </div>
        </div>
    </div>
</div>
