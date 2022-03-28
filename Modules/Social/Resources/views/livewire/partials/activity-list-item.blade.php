<div class="bg-primary px-4 py-6 shadow sm:p-6 ">
    <article aria-labelledby="{{ 'activity-item-' . $activity['id'] }}">
        <div class="flex justify-beetween items-center">
            <div>
                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        @if(!is_null($activity['user']['avatar']))
                            <img class="h-10 w-10 rounded-full bg-neutral-dark" src="{{ $activity['user']['avatar'] }}" alt="" />
                        @else
                            <x-heroicon-o-check class="h-10 w-10 rounded-full bg-neutral-dark" />
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="text-sm font-medium text-gray-900">
                            {{ $activity['title'] }}
                        </span>
                        <span class="text-sm text-gray-500">
                            <time datetime="{{ $activity['created_at'] }}">{{ $activity['created_at'] }}</time>
                        </span>
                    </div>
                </div>
                <p id="{{ 'activity-title-' . $activity['id'] }}" class="mt-4 text-base font-medium text-gray-900">
                    {{ $activity['message'] }}
                </p>
            </div>
            <div class="text-xs ml-3 w-60 space-y-1">
                @if (!is_null($activity['project']))
                    <a href="{{ $activity['project']['link'] }}" class="flex items-center"><span>View Project</span><x-heroicon-o-chevron-right class="w-3 h-3 ml-2" /></a>
                @endif
                @if (!is_null($activity['user']['avatar']) && !is_null($activity['project']))
                <a href="#" class="flex items-center"><x-heroicon-o-star class="w-3 h-3 mr-2" /><span>Add to favorites</span></a>
                <a href="#" class="flex items-center"><x-heroicon-o-mail class="w-3 h-3 mr-2" /><span>Request to join</span></a>
                @endif
            </div>
        </div>
        @isset($activity['members'])
        <div class="mt-6 flex -space-x-1">
            @foreach ($activity['members'] as $user)
                @if ($loop->index >= 5)
                    <div class="w-6">
                        <div class="w-full rounded-full bg-gray-200 text-sm">+{{ $loop->count - $loop->index }}</div>
                    </div>
                    @break;
                @else
                    <div class="w-6">
                        <img class="w-full rounded-full" src="{{ $user['avatar'] }}">
                    </div>
                @endif
            @endforeach
        </div>
        @endisset
    </article>
</div>
