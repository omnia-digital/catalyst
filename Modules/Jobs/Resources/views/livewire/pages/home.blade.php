@extends('resources::livewire.layouts.main-layout')

@section('content')
<div>
    <div class="xl:grid xl:grid-cols-9 xl:gap-9">
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
                            Looking for contractors? We are currently offering new job posts at a discount for a limited time.
                            <p>
                                <a href="{{ route('jobs.create') }}"
                                   class="my-2 inline-flex items-center px-4 py-2 border border-transparent leading-6 font-medium rounded-md text-white bg-red-600 hover:text-white-600 hover:bg-red-500
                              focus:outline-none focus:border-light-red-300 focus:shadow-outline-light-red active:bg-red-50 active:text-white-700 transition duration-150 ease-in-out">
                                    Post A Job
                                </a>
                            </p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
