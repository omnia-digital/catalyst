@extends('jobs::livewire.layouts.main-layout')

@section('content')
<div>
    <div class=":grid grid-cols-9 gap-9">
        {{--  Latest Jobs  --}}
        <div class="col-span-9 mt-10">
            <h2 class="text-xl font-medium text-dark-text-color py-2">Latest Jobs</h2>

            <div class="bg-primary shadow overflow-hidden sm:rounded-md">
                <ul>
                    @forelse($jobs as $job)
                        <x-job.item
                            wire:key="latest-job-{{ $job->id }}"
                            class="{{ $loop->first ? 'border-t border-neutral-light' : '' }}"
                            :job="$job"/>
                    @empty
                        <li class="p-20 text-lg text-base-text-color text-center">
                            Looking for contractors? We are currently offering new job posts at a discount for a limited time.
                            <p>
                                <a href="{{ route('jobs.create') }}"
                                   class="my-2 inline-flex items-center px-4 py-2 border border-transparent leading-6 font-medium rounded-md text-primary bg-red-600 hover:text-primary-600 hover:bg-red-500
                              focus:outline-none focus:border-light-red-300 focus:shadow-outline-light-red active:bg-red-50 active:text-primary-700 transition duration-150 ease-in-out">
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
