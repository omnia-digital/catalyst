@extends('jobs::livewire.layouts.pages.default-page-layout')

@section('content')
    <div>
    {{--  Subscribe widget  --}}
{{--    <livewire:jobs::components.subscribe-widget/>--}}

    {{--  Featured Jobs  --}}
    @if (count($featuredJobs))
        <div>
            <h2 class="text-xl font-medium text-gray-700 py-2">Featured Jobs</h2>

            <ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featuredJobs as $job)
                    <x-jobs::job.featured-item wire:key="featured-job-{{ $job->id }}" :job="$job"/>
                @endforeach
            </ul>
        </div>
    @endif

    {{--  Latest Jobs  --}}
    <div class="mt-10">
        <h2 class="text-xl font-medium text-gray-700 py-2">Latest Jobs</h2>

        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul>
                @forelse($jobs as $job)
                    <x-job.item
                            wire:key="latest-job-{{ $job->id }}"
                            class="{{ $loop->first ? 'border-t border-gray-200' : '' }}"
                            :job="$job"/>
                @empty
                    <li class="p-20 text-lg text-gray-600 text-center">
                        {{ \Trans::get('Looking for help? Post a job and you can start getting applicants today.') }}
                        <p>
                            <a href="{{ route('jobs.job.create') }}"
                               class="my-2 inline-flex items-center px-4 py-2 border border-transparent leading-6 font-medium rounded-md text-white bg-red-600 hover:text-white-600 hover:bg-red-500
                              focus:outline-none focus:border-light-red-300 focus:shadow-outline-light-red active:bg-red-50 active:text-white-700 transition duration-150 ease-in-out">
                                Post a job
                            </a>
                        </p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    {{--  Tooltips  --}}
    <x-jobs::tooltip trigger="company">Company</x-jobs::tooltip>
    <x-jobs::tooltip trigger="location">Location</x-jobs::tooltip>
    <x-jobs::tooltip trigger="payment-type-budget">Payment Type & Budget</x-jobs::tooltip>
</div>

@endsection
