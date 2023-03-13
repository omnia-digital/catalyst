@props([
'job',
'editable' => false
])

@php
    $class = $job->hasAddon(\Modules\Jobs\Enums\JobAddons::HIGHLIGHT_JOB) ? 'bg-yellow-50' : 'bg-secondary';
@endphp

<li {{ $attributes->merge(['class' => $class]) }}>
    <a href="{{ $editable ? route('jobs.update', $job) : route('jobs.show', ['team' => $job->company, 'job' => $job]) }}" class="block hover:bg-primary hover:shadow-2xl focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
        <div class="flex items-center px-4 py-4 sm:px-6">
            <div class="min-w-0 flex-1 flex items-center">
                <div class="flex-shrink-0">
                    <x-job.logo :job="$job"/>
                </div>
                <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                    <div>
                        <div class="text-base-text-color leading-5 font-medium text-primary truncate">{{ $job->title }}</div>
                        <div class="mt-2 flex items-center text-sm leading-5 text-base-text-color">
                            <div class="sm:flex">
                                <div class="mr-6 flex items-center text-sm leading-5 text-base-text-color">
                                    <x-heroicon-o-briefcase id="company" class="flex-shrink-0 mr-1.5 h-5 w-5 text-light-text-color"/>
                                    {{ $job->company->name }}
                                </div>
                                <div class="mr-6 flex items-center text-sm leading-5 text-base-text-color sm:mt-0">
                                    <x-heroicon-o-location-marker id="location" class="flex-shrink-0 mr-1.5 h-5 w-5 text-light-text-color"/>
                                    {{ $job->location }} {{ $job->is_remote ? '(Remote)' : '' }}
                                </div>
                                <div class="flex items-center text-sm leading-5 text-base-text-color sm:mt-0">
                                    <x-heroicon-o-credit-card id="payment-type-budget" class="flex-shrink-0 mr-1.5 h-5 w-5 text-light-text-color"/>
                                    {{ ucfirst($job->payment_type) }} {{ $job->budget ? ' - ' . \Platform::money($job->budget) : '' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div>
                            <div class="text-sm leading-5 text-dark-text-color">
                                @foreach ($job->tags->pluck('name') as $name)
                                    <x-tag class="rounded-full bg-green-100 text-green-800 text-sm">
                                        {{ $name }}
                                    </x-tag>
                                @endforeach
                            </div>

                            <x-tooltip wire:key="{{ $job->id . time() }}" trigger="posted-on-{{ $job->id }}">{{ $job->created_at->format('Y-m-d') }}</x-tooltip>

                            <div class="mt-2 flex items-center text-sm leading-5 text-base-text-color">
                                <x-heroicon-s-calendar id="posted-on-{{ $job->id }}" class="flex-shrink-0 mr-1.5 h-5 w-5 text-light-text-color"/>
                                <span>
                                    Posted
                                    <time datetime="2020-01-07">{{ $job->created_at->diffForHumans() }}</time>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <x-heroicon-s-chevron-right class="h-5 w-5 text-light-text-color"/>
            </div>
        </div>
    </a>
</li>
