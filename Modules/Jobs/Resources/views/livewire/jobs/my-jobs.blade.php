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
                    <a href="{{ route('jobs.create') }}" class="rounded shadow py-2 px-4 bg-light-blue-500 text-white hover:bg-light-blue-600 hover:shadow-2xl transition duration-200">
                        Create your first job
                    </a>
                </li>
            @endforelse
        </ul>
    </div>

    {{--  Tooltips  --}}
    <x-tooltip trigger="company">Company</x-tooltip>
    <x-tooltip trigger="location">Location</x-tooltip>
    <x-tooltip trigger="payment-type-budget">Payment Type & Budget</x-tooltip>
</div>
