@props([
'job',
'editable' => false
])

<li {{ $attributes }}>
    <a href="{{ $editable ? route('jobs.update', $job) : $job->applyLink }}"
       target="{{ $editable ? '_self' : '_blank' }}"
       class="block hover:bg-light-blue-50 hover:shadow-2xl focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
        <div class="px-4 py-4 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="text-base leading-5 font-medium text-light-blue-600 truncate">
                    {{ $job->title }}
                </div>
                <div class="ml-2 space-x-2 flex-shrink-0 flex">
                    @foreach ($job->tags->pluck('name') as $name)
                        <x-tag class="rounded-full bg-green-100 text-green-800 text-sm">
                            {{ $name }}
                        </x-tag>
                    @endforeach
                </div>
            </div>
            <div class="mt-2 sm:flex sm:justify-between">
                <div class="sm:flex">
                    <div class="mr-6 flex items-center text-sm leading-5 text-gray-500">
                        <x-heroicon-o-briefcase id="company" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                        {{ $job->company->name }}
                    </div>
                    <div class="mr-6 flex items-center text-sm leading-5 text-gray-500 sm:mt-0">
                        <x-library::icons.icon name="fa-light fa-location-dot" id="location" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                        {{ $job->location }} {{ $job->is_remote ? '(Remote)' : '' }}
                    </div>
                    <div class="flex items-center text-sm leading-5 text-gray-500 sm:mt-0">
                        <x-heroicon-o-credit-card id="payment-type-budget"
                                                  class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                        {{ ucfirst($job->payment_type) }} {{ $job->budget ? ' - ' . Platform::money($job->budget) : '' }}
                    </div>
                </div>

                <x-tooltip wire:key="{{ $job->id . time() }}"
                           trigger="posted-on-{{ $job->id }}">{{ $job->created_at->format('Y-m-d') }}</x-tooltip>
                <div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mt-0">
                    <x-heroicon-s-calendar id="posted-on-{{ $job->id }}"
                                           class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                    <span>
                        Posted
                        <time datetime="2020-01-07">{{ $job->created_at->diffForHumans() }}</time>
                    </span>
                </div>
            </div>
        </div>
    </a>
</li>
