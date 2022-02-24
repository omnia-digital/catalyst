<li {{ $attributes }}>
    <div>
        <div class="flex space-x-3">
            <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full" src="{{ $comment->user->profile_photo_url }}" alt="{{ $comment->user->name }}" />
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-medium text-gray-900">
                    <a href="{{ route('profile.show') }}" class="hover:underline">{{ $comment->user->name }}</a>
                </p>
                <p class="text-sm text-gray-500">
                    <a href="#" class="hover:underline">
                        <time datetime="{{ $comment->created_at }}">{{ $comment->created_at->diffForHumans() }}</time>
                    </a>
                </p>
            </div>
        </div>
    </div>
    <div class="mt-2 text-sm text-gray-700 space-y-4">{{ $comment->body }}</div>
</li>