@props([
'logoUrl',
'title',
'companyName',
'location',
'isRemote',
'paymentType',
'budget',
'tags',
'selectedTags',
'editable' => false
])

@php
    $class = 'bg-white';
@endphp

<li {{ $attributes->merge(['class' => $class]) }}>
    <a href="#" class="block hover:bg-light-blue-50 hover:shadow-2xl focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
        <div class="flex items-center px-4 py-4 sm:px-6">
            <div class="min-w-0 flex-1 flex items-center">
                <div class="flex-shrink-0">
                    @if ($logoUrl)
                        <img class="w-16 h-16 rounded-full flex-shrink-0" src="{{ $logoUrl }}" alt="{{ $companyName }}">
                    @else
                        <x-jobs::icons.default-logo class="w-16 h-16 rounded-full flex-shrink-0"/>
                    @endif
                </div>
                <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                    <div>
                        <div class="text-base leading-5 font-medium text-light-blue-600 truncate">{{ $title }}</div>
                        <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                            <div class="sm:flex">
                                <div class="mr-6 flex items-center text-sm leading-5 text-gray-500">
                                    <x-heroicon-o-briefcase id="company" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                                    {{ $companyName }}
                                </div>
                                <div class="mr-6 flex items-center text-sm leading-5 text-gray-500 sm:mt-0">
                                    <x-heroicon-o-location-marker id="location" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                                    {{ $location }} {{ $isRemote ? '(Remote)' : '' }}
                                </div>
                                <div class="flex items-center text-sm leading-5 text-gray-500 sm:mt-0">
                                    <x-heroicon-o-credit-card id="payment-type-budget" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                                    {{ ucfirst($paymentType) }} {{ $budget }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div>
                            <div class="text-sm leading-5 text-gray-900">
                                @foreach ($selectedTags as $key)
                                    <x-tag class="rounded-full bg-green-100 text-green-800 text-sm">
                                        {{ $tags[$key] }}
                                    </x-tag>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <x-heroicon-s-chevron-right class="h-5 w-5 text-gray-400"/>
            </div>
        </div>
    </a>
</li>
