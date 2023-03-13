<div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
    <div class="bg-white overflow-hidden shadow rounded-lg space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
        <div class="border-b border-gray-200 px-4 py-5 sm:px-6">
            <div class="lg:flex lg:items-center lg:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                        {{ $job->title }}
                    </h2>
                    <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap">
                        <div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mr-6">
                            <x-heroicon-o-briefcase id="company" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                            {{ $job->company->name }}
                        </div>
                        <div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mr-6">
                            <x-heroicon-o-location-marker id="location" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                            {{ $job->location }} {{ $job->is_remote ? '(Remote)' : '' }}
                        </div>
                        <div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mr-6">
                            <x-heroicon-o-credit-card id="payment-type-budget" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                            {{ ucfirst($job->payment_type) }} {{ $job->budget ? ' - ' . \Modules\Jobs\LaraContract::money($job->budget) : '' }}
                        </div>
                        <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                            <x-heroicon-s-calendar id="posted-on" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                            <span>
                                Posted
                                <time datetime="{{ $job->created_at->format('Y-m-d') }}">{{ $job->created_at->diffForHumans() }}</time>
                            </span>
                        </div>
                        <div class="mt-2 ml-2 flex items-center text-sm leading-5 text-gray-500">
                            @foreach($job->tags->pluck('name') as $tag)
                                <x-tag class="bg-teal-100 text-teal-800 rounded-full text-sm ml-2">{{ $tag }}</x-tag>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-5 flex lg:mt-0 lg:ml-4">
                    @if (false)
                        <span class="mr-3 shadow-sm rounded-md">
                            <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out">
                                <x-heroicon-s-pencil class="-ml-1 mr-2 h-5 w-5 text-gray-500"/> Edit
                            </button>
                        </span>
                    @endif

                    <span class="shadow-sm rounded-md">
                        <a href="{{ $job->applyLink }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-light-blue-600 hover:bg-light-blue-500 focus:outline-none focus:shadow-outline-light-blue focus:border-light-blue-700 active:bg-light-blue-700 transition duration-150 ease-in-out">
                            <x-heroicon-s-cursor-click class="-ml-1 mr-2 h-5 w-5"/> Apply
                        </a>
                    </span>
                </div>
            </div>
        </div>
        <div class="px-6">
            <h3 class="text-base font-medium leading-7 text-gray-900 sm:text-xl sm:leading-9 sm:truncate">
                Job Description
            </h3>
            <p class="text-base text-gray-900 mt-2">{{ $job->description }}</p>
        </div>
        <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
            <h3 class="text-base font-medium leading-7 text-gray-900 sm:text-xl sm:leading-9 sm:truncate">
                About {{ $this->job->company->name }}
            </h3>
            <p class="text-base text-gray-900 mt-2">{{ $this->job->company->about }}</p>
        </div>
    </div>

{{--    <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">--}}
{{--        <x-advertising/>--}}
{{--    </aside>--}}

    {{--  Tooltips  --}}
    <x-tooltip trigger="company">Company</x-tooltip>
    <x-tooltip trigger="location">Location</x-tooltip>
    <x-tooltip trigger="payment-type-budget">Payment Type & Budget</x-tooltip>
    <x-tooltip trigger="posted-on">{{ $job->created_at->format('Y-m-d') }}</x-tooltip>
</div>
