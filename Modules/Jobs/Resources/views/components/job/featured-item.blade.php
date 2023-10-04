@php use Modules\Jobs\Enums\JobAddons; @endphp
@props(['job'])

@php
    $class = 'col-span-1 rounded-lg shadow ';
    $class .= $job->hasAddon(JobAddons::HIGHLIGHT_JOB) ? 'bg-yellow-50' : 'bg-white';
@endphp

<li {{ $attributes->merge(['class' => $class]) }}>
    <div class="w-full flex items-center justify-between p-6 space-x-6">
        <div class="flex-1 truncate">
            <div class="flex items-center space-x-3 mb-2">
                <h3 class="text-gray-900 text-base leading-5 font-medium truncate">{{ $job->title }}</h3>
            </div>

            @foreach ($job->tags->pluck('name') as $tag)
                <x-tag class="bg-teal-100 text-teal-800 rounded-full text-sm">{{ $tag }}</x-tag>
            @endforeach

            <div class="space-y-2 mt-4">
                <p class="flex items-center mt-1 text-gray-500 text-sm leading-5 truncate">
                    <x-heroicon-o-briefcase id="company" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                    {{ $job->company->name }}
                </p>

                <p class="flex items-center mt-1 text-gray-500 text-sm leading-5 truncate">
                    <x-library::icons.icon name="fa-light fa-location-dot" id="location" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>

                    @if ($job->location)
                        <span class="mr-2">{{ $job->location }}</span>
                    @endif

                    @if ($job->is_remote)
                        <x-tag class="text-gray-700 bg-green-300 rounded text-xs">Remote</x-tag>
                    @endif
                </p>

                <p class="flex items-center mt-1 text-gray-500 text-sm leading-5 truncate">
                    <x-heroicon-o-credit-card id="payment-type-budget"
                                              class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                    {{ ucfirst($job->payment_type) }} {{ $job->budget ? ' - ' . Catalyst::money($job->budget) : '' }}
                </p>

                <x-tooltip wire:key="{{ $job->id . time() }}"
                           trigger="posted-on-{{ $job->id }}">{{ $job->created_at->format('Y-m-d') }}</x-tooltip>
                <p class="flex items-center mt-1 text-gray-500 text-sm leading-5 truncate">
                    <x-heroicon-o-calendar id="posted-on-{{ $job->id }}"
                                           class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                    Posted {{ $job->created_at->diffForHumans() }}
                </p>
            </div>
        </div>

        <x-job.logo :job="$job"/>
    </div>
    <div class="border-t border-gray-200">
        <div class="-mt-px flex">
            {{--            <div class="w-0 flex-1 flex border-r border-gray-200">--}}
            {{--                <a href="{{ route('jobs.show', $job) }}" class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm leading-5 text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 transition ease-in-out duration-150">--}}
            {{--                    <x-heroicon-s-eye class="w-5 h-5 text-gray-400"/>--}}
            {{--                    <span class="ml-3">View</span>--}}
            {{--                </a>--}}
            {{--            </div>--}}
            <div class="-ml-px w-0 flex-1 flex">
                <a href="{{ route('jobs.show', ['team' => $job->company, 'job' => $job]) }}"
                   class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm leading-5 text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10 transition ease-in-out duration-150">
                    <x-heroicon-s-cursor-click class="w-5 h-5 text-gray-400"/>
                    <span class="ml-3">Apply</span>
                </a>
            </div>
        </div>
    </div>
</li>
