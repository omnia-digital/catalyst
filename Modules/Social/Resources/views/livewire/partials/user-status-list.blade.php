<section aria-labelledby="people-heading" class="card py-6">
    <div class="px-6 py-3">
{{--            <x-library::heading.2 id="people-list" class="text-xl font-medium text-gray-900">--}}
{{--                {{ Trans::get('People') }}--}}
{{--            </x-library::heading.2>--}}
        <div class="mt-6 flow-root">
            <ul role="list" class="-my-4">
                @forelse ($this->userList as $user)
                    <li class="flex items-center py-2 space-x-3">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="hover:underline text-sm font-medium text-gray-900">
                                <a href="{{ $user->url() }}">{{ $user->name }}</a>
                            </p>
{{--                                <p class="text-sm text-gray-500">--}}
{{--                                    <a href="{{ $user->url() }}">{{ '@' . $user->handle }}</a>--}}
{{--                                </p>--}}
                        </div>
                        <div class="flex-shrink-0">
                            <livewire:award-stack :user="$user" :team="$team" wire:key="award-stack-{{ $user->id }}" />
{{--                                <livewire:social::partials.follow-button :model="$user"/>--}}
                        </div>
                    </li>
                @empty
                    <li class="flex items-center py-4 space-x-3">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900">
                                {{ Trans::get('No one to follow') }}
                            </p>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
    
</section>
