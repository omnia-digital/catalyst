@php use Modules\Jobs\Enums\JobAddons; @endphp
@props([
'job',
'editable' => false
])

@php
    $class = $job->hasAddon(JobAddons::HIGHLIGHT_JOB) ? 'bg-yellow-50' : 'bg-secondary';
@endphp

<li {{ $attributes->merge(['class' => $class]) }}>
    <a href="{{ $editable ? route('jobs.job.update', $job) : route('jobs.job.show', ['team' => $job->company->id, 'job' => $job]) }}"
       class="block group hover:border-primary
    hover:shadow-2xl border-4 border-transparent
    focus:outline-none
    focus:bg-gray-50 transition duration-150 ease-in-out">
        <div class="flex items-center px-4 py-4 sm:px-6">
            <div class="min-w-0 flex-1 flex items-center">
                <div class="flex-shrink-0">
                    <x-jobs::job.logo :job="$job"/>
                </div>
                <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                    <div>
                        <h3 class="leading-5 font-medium truncate text-primary">{{ $job->title }}</h3>
                        <div class="mt-2 flex items-center text-sm leading-5 text-base-text-color ">
                            <div class="sm:flex-1">
                                <div class="mr-6 flex items-center text-sm leading-5 text-base-text-color">
                                    <x-heroicon-o-briefcase id="company"
                                                            class="flex-shrink-0 mr-1.5 h-5 w-5 text-light-text-color"/>
                                    {{ $job->company->name }}
                                </div>
                                @if (!empty($job->location) || !empty($job->is_remote))
                                    <div class="mr-6 flex items-center text-sm leading-5 text-base-text-color sm:mt-0">
                                        <x-library::icons.icon name="fa-light fa-location-dot" id="location"
                                                                      class="flex-shrink-0 mr-1.5 h-5 w-5 text-light-text-color "/>
                                        {{ $job->location }} {{ $job->is_remote ? '(Remote)' : '' }}
                                    </div>
                                @endif
                                <div class="flex items-center text-sm leading-5 text-base-text-color sm:mt-0">
                                    <x-heroicon-o-credit-card id="payment-type-budget"
                                                              class="flex-shrink-0 mr-1.5 h-5 w-5 text-light-text-color"/>
                                    {{ ucfirst($job->payment_type) }} {{ $job->budget ? ' - ' . Catalyst::money($job->budget) : '' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div>
                            <div class="text-sm leading-5 text-dark-text-color">
                                @foreach ($job->skills as $skill)
                                    <x-tag :name="$skill->name"
                                           class="rounded-full bg-green-100 text-green-800 text-sm"/>
                                @endforeach
                            </div>

                            <x-jobs::tooltip wire:key="{{ $job->id . time() }}"
                                             trigger="posted-on-{{ $job->id }}">{{ $job->created_at->format('Y-m-d') }}</x-jobs::tooltip>

                            <div class="mt-2 flex items-center text-sm leading-5 text-base-text-color">
                                <x-heroicon-s-calendar id="posted-on-{{ $job->id }}"
                                                       class="flex-shrink-0 mr-1.5 h-5 w-5 text-light-text-color"/>
                                <span>
                                    Posted
                                    <time datetime="2020-01-07">{{ $job->created_at->diffForHumans() }}</time>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end">
                <div class="flex items-center mr-4">
                    @if ($job->is_active)
                        <span class="text-success-600 flex items-center "><x-library::icons.icon
                                    name="fa-solid fa-circle" size="w-3 h-3" class="mr-2"/> {{
                        Translate::get('Active') }}</span>
                    @else
                        <span class="text-danger-600 flex items-center"><x-library::icons.icon name="fa-solid fa-circle"
                                                                                               size="w-3 h-3"
                                                                                               class="mr-2"/> {{  Translate::get
                        ('Inactive') }}</span>
                    @endif
                </div>
                <x-heroicon-s-chevron-right class="h-5 w-5 text-light-text-color"/>
            </div>
        </div>
    </a>
</li>
