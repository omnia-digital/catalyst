<section aria-labelledby="who-to-follow-heading" class="card">
    <div class="p-6">
            <h2 id="who-to-follow-heading" class="text-xl font-medium text-gray-900">
                Who to follow
            </h2>
            <div class="mt-6 flow-root">
                <ul role="list" class="-my-4">
                    @forelse ($this->whoToFollow as $user)
                        <li class="flex items-center py-4 space-x-3">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="{{ $user->profile_photo_url }}" alt="" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900">
                                    <a href="{{ $user->url() }}">{{ $user->name }}</a>
                                </p>
                                <p class="text-sm text-gray-500">
                                    <a href="{{ $user->url() }}">{{ '@' . $user->profile?->handle }}</a>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <livewire:social::partials.follow-button :model="$user"/>
                            </div>
                        </li>
                    @empty
                        <li class="flex items-center py-4 space-x-3">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900">
                                    No one to follow
                                </p>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
            <div class="mt-6">
                @if ($this->whoToFollow->count())
                    <a href="#" class="w-full block text-center px-4 py-2  shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        View all
                    </a>
                @endif
            </div>
        </div>
</section>
