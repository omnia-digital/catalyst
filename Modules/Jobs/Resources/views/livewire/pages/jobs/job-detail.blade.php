@extends('jobs::livewire.layouts.pages.default-page-layout')

@section('content')
    <div class="mb-3 rounded-b-lg pl-4 flex items-center bg-primary">
        <div class="mr-4 hover:bg-neutral-dark p-2 rounded-full bg-secondary hover:text-secondary">
            <a href="{{ route('jobs.home') }}">
                <x-heroicon-o-arrow-left class="h-6"/>
            </a>
        </div>
        <a href="{{ route('jobs.home') }}">
            <x-library::heading.1
                    class="py-4 hover:cursor-pointer">{{ Trans::get('Job Detail') }}</x-library::heading.1>
        </a>
    </div>

    <div class="mt-4 lg:grid lg:grid-cols-12 lg:gap-x-5">
        <div class="bg-white overflow-hidden shadow rounded-lg space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
            <div class="border-b border-gray-200 px-4 py-5 sm:px-6">
                <div class="lg:flex lg:items-center lg:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                            {{ $job->title }}
                        </h2>
                        <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap">
                            <div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mr-6">
                                <x-heroicon-o-briefcase id="company"
                                                        class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                                {{ $job->company->name }}
                            </div>
                            <div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mr-6">
                                <x-library::icons.icon name="fa-light fa-location-dot" id="location"
                                                              class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                                {{ $job->location }} {{ $job->is_remote ? '(Remote)' : '' }}
                            </div>
                            <div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mr-6">
                                <x-heroicon-o-credit-card id="payment-type-budget"
                                                          class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                                {{ ucfirst($job->payment_type) }} {{ $job->budget ? ' - ' . Platform::money($job->budget) : '' }}
                            </div>
                            <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                <x-heroicon-s-calendar id="posted-on"
                                                       class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                                <span>
                                Posted
                                <time datetime="{{ $job->created_at->format('Y-m-d') }}">{{ $job->created_at->diffForHumans() }}</time>
                            </span>
                            </div>
                            <div class="mt-2 ml-2 flex items-center text-sm leading-5 text-gray-500">
                                @foreach ($job->skills->pluck('name') as $skill)
                                    <x-tag :name="$skill" class="bg-teal-100 text-teal-800 rounded-full text-sm ml-2"/>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 flex lg:mt-0 lg:ml-4">
                        @if (auth()->check() && auth()->user()->can('update', $job))
                            <span class="mr-3 shadow-sm rounded-md">
                            <x-library::button.link href="{{ route('jobs.job.update', $job) }}" type="button"
                                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                                <x-heroicon-s-pencil class="-ml-1 mr-2 h-5 w-5 text-gray-500"/> {{ Trans::get('Edit') }}
                            </x-library::button.link>
                        </span>
                        @elseif (auth()->check() && auth()->user()->can('apply', $job))
                            <span class="shadow-sm rounded-md">
                            <x-library::button.link href="{{ $job->applyLink }}" target="_blank"
                                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-light-blue-600 hover:bg-light-blue-500 focus:outline-none focus:shadow-outline-light-blue focus:border-light-blue-700 active:bg-light-blue-700 transition duration-150 ease-in-out">
                                <x-heroicon-s-cursor-click class="-ml-1 mr-2 h-5 w-5"/> {{ Trans::get('Apply') }}
                            </x-library::button.link>
                        @endif
                    </span>
                    </div>
                </div>
            </div>
            <div class="px-6">
                <h3 class="text-base font-medium leading-7 text-gray-900 sm:text-xl sm:leading-9 sm:truncate">
                    {{ Trans::get('Job Description') }}
                </h3>
                <p class="text-base text-gray-900 mt-2">{{ $job->description }}</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                <h3 class="text-base font-medium leading-7 text-gray-900 sm:text-xl sm:leading-9 sm:truncate">
                    {{ Trans::get('About') }} {{ $this->job->company->name }}
                </h3>
                <p class="text-base text-gray-900 mt-2">{{ $this->job->company->about }}</p>
            </div>
        </div>

        {{--    <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">--}}
        {{--        <x-advertising/>--}}
        {{--    </aside>--}}

        {{--  Tooltips  --}}
        <x-jobs::tooltip trigger="company">{{ Trans::get('Company') }}</x-jobs::tooltip>
        <x-jobs::tooltip trigger="location">{{ Trans::get('Location') }}</x-jobs::tooltip>
        <x-jobs::tooltip trigger="payment-type-budget">{{ Trans::get('Payment Type & Budget') }}</x-jobs::tooltip>
        <x-jobs::tooltip trigger="posted-on">{{ $job->created_at->format('Y-m-d') }}</x-jobs::tooltip>
    </div>
@endsection
