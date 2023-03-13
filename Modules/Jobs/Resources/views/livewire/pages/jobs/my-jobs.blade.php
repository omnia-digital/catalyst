@extends('jobs::livewire.layouts.pages.default-page-layout')

@section('content')
    <div>
        <div class="mb-3 rounded-b-lg px-4 flex items-center justify-between bg-primary">
            <div class="flex items-center">

                <a href="{{route('jobs.home')}}">
                    <x-library::heading.1 class="py-4 hover:cursor-pointer">{{ Trans::get('My Jobs') }}</x-library::heading.1>
                </a>
            </div>
            <div class="flex items-center">
                @if(auth()->user()->can('create', \Modules\Jobs\Models\JobPosition::class))
                    @auth
                        <x-library::button.link
                                href="{{ route('jobs.job.create') }}"
                                class="py-2 w-full h-10"
                        >{{ \Trans::get('+ Create Job') }}</x-library::button.link>
                        <livewire:resources::pages.resources.create/>
                    @else
                        <x-library::button
                                class="py-2 w-full h-10"
                                wire:click="loginCheck"
                        >+ New Resource</x-library::button>
                        <livewire:authentication-modal/>
                    @endauth
                @endif
            </div>
        </div>
        <div>
            <h2 class="text-xl font-medium text-gray-700 py-2">{{ Auth::user()->currentTeam->name }}'s Jobs</h2>

            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul>
                    @forelse($jobs as $job)
                        <x-job.item
                                wire:key="latest-job-{{ $job->id }}"
                                class="{{ $loop->first ? 'border-t border-gray-200' : '' }}"
                                :job="$job"
                                editable="true"/>
                    @empty
                        <li class="p-20 text-center">
                            <p class="mb-4 text-lg text-gray-600">You don't have any jobs.</p>
                            <a href="{{ route('jobs.job.create') }}" class="rounded shadow py-2 px-4 bg-primary text-white hover:bg-primary hover:shadow-2xl transition duration-200">
                                Create your first job
                            </a>
                        </li>
                    @endforelse
                </ul>
            </div>

            {{--  Tooltips  --}}
            <x-jobs::tooltip trigger="company">{{ Trans::get('Company') }}</x-jobs::tooltip>
            <x-jobs::tooltip trigger="location">{{ Trans::get('Location') }}</x-jobs::tooltip>
            <x-jobs::tooltip trigger="payment-type-budget">{{ Trans::get('Payment Type & Budget') }}</x-jobs::tooltip>
        </div>
    </div>
@endsection
