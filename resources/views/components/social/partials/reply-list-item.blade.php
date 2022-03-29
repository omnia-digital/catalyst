<li {{ $attributes }}>
    <div>
        <div class="flex space-x-3">
            <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full" src="{{ $reply->user->profile_photo_url }}" alt="{{ $reply->user->name }}" />
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-medium text-dark-text-color">
                    <a href="{{ route('user.profile', $reply->user->handle) }}" class="hover:underline">{{ $reply->user->name }}</a>
                </p>
                <p class="text-sm text-base-text-color">
                    <a href="#" class="hover:underline">
                        <time datetime="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</time>
                    </a>
                </p>
            </div>
        </div>
    </div>
    <div class="mt-2 text-sm text-dark-text-color space-y-4">{{ $reply->body }}</div>
</li>
