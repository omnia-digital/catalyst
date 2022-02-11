<div>
    <!-- mobile slideout sidebar -->
    @if ($isOpen)
        <div>
            <div class="fixed inset-0 flex z-40 md:hidden">
                <div aria-hidden="true" class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
                <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button
                            type="button"
                            class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            tabindex="0"
                            wire:click="closeMobileMenu"
                        >
                            <span class="sr-only">Close sidebar</span>
                            <x-heroicon-o-x class="text-white"/>
                        </button>
                    </div>
                    <div class="flex-shrink-0 flex items-center px-4">
                        <!-- mobile logo -->
                        <img class="h-8 mr-2 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Indie Game Dev logo">
                        <p class="text-green-500 text-3xl font-bold">IGD</p>
                    </div>
                    <div class="mt-5 flex-1 h-0 overflow-y-auto">
                        <!-- mobile nav -->
                        <nav class="px-2 space-y-1">
                            @foreach ($navigation as $item)
                                <a
                                    href="{{ route($item['name']) }}"
                                    class="{{ request()->routeIs($item['name']) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} {{ 'group flex items-center px-2 py-2 text-base font-medium rounded-md' }}">
                                    <x-dynamic-component :component="$item['icon']" class="{{ $item['current'] ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }} mr-3 flex-shrink-0 h-6 w-6"
                                                         aria-hidden="true"/>
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </nav>
                    </div>
                </div>
                <div class="flex-shrink-0 w-14" aria-hidden="true">
                    <!-- Dummy element to force sidebar to shrink to fit close icon -->
                </div>
            </div>
        </div>
    @endif

<!-- Static sidebar for desktop -->
    <div class="hidden md:flex md:w-80 md:flex-col md:fixed md:inset-y-0 shadow-lg">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex-1 flex flex-col min-h-0 ">
            <div class="flex items-center pl-6 h-16 flex-shrink-0">
                <!-- desktop logo -->
                <img class="h-8 mr-2 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Workflow">
                <p class="text-base font-bold">Evangelism Alliance</p>
            </div>
            <a href="{{ route('social.home') }}">
                <div class="flex-shrink-0 pl-6 flex p-4">
                    <div class="flex items-center">
                        <div>
                            <img class="inline-block h-12 w-12 rounded-full"
                                 src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                 alt=""/>
                        </div>
                        <div class="ml-3">
                            <p class="text-base font-semibold">
                                Jacob Jones
                            </p>
                            <p class="text-sm font-medium">
                                michelle.rivera@example.com
                            </p>
                        </div>
                    </div>
                </div>
            </a>
            <div class="flex flex-col divide-y">
                <nav class="py-4 space-y-1">
                    @foreach ($navigation as $item)
                        <a
                            href="{{ route($item['name']) }}"
                            class="{{ request()->routeIs($item['name']) ? 'bg-gray-200 font-semibold text-black' : 'text-gray-400 hover:text-black hover:bg-gray-200' }} 
                            {{ 'w-full pl-6 group flex items-center px-2 py-2 text-lg font-medium rounded-md' }}"
                        >
                            <x-dynamic-component 
                                :component="$item['icon']" 
                                class="mr-3 flex-shrink-0 h-6 w-6"
                                aria-hidden="true" 
                            />
                            {{ $item['label'] }} @if($item['name'] == 'social.home')<span class="ml-4 text-sm w-5 h-5 flex items-center justify-center text-white bg-black rounded-full">3</span>@endif
                        </a>
                    @endforeach
                    {{-- <Link v-for="item in navigation" :key="item.name" :href="route(item.name)"
                          :class="[$page.component === '' ? 'bg-tertiary text-white' :
                    'text-gray-300 hover:bg-tertiary hover:text-white',
                    'group flex items-center px-2 py-2 text-lg font-medium rounded-md']">
                        <component :is="item.icon" :class="[item.current ? 'text-white' : 'text-gray-400 group-hover:text-gray-300', 'mr-3 flex-shrink-0 h-6 w-6']" aria-hidden="true"/>
                        {{ item.label }}
                    </Link> --}}
                </nav>
                <div class="flex-1 p-6 space-y-1 overflow-y-auto">
                    <h2 class="text-base font-bold">Applications</h2>
                    <div x-data="setup()">
                        <ul class="flex justify-center items-center my-4">
                            <template x-for="(tab, index) in tabs" :key="index">
                                <li class="flex flex-1 text-sm cursor-pointer py-2 px-6 text-gray-500 border-b-2 justify-center"
                                    :class="activeTab===index ? 'text-black font-bold border-black' : ''" @click="activeTab = index"
                                    x-html="tab + notifications"></li>
                            </template>
                        </ul>

                        <div class="bg-white mx-auto">
                            <div x-show="activeTab===0">
                                <div class="flex justify-between">
                                    <div class="flex flex-col divide-y">
                                        @foreach ($invitations as $invitation)
                                            <div class="py-3">
                                                <div class="flex items-center">
                                                    <div class="mr-3 w-12 h-12 rounded-full shadow">
                                                        <img class="w-full h-full overflow-hidden object-cover object-center rounded-full" src="{{ $invitation['user']['avatar'] }}" alt="avatar" />
                                                    </div>
                                                    <div class="flex-1">
                                                        <h3 class="mb-2 sm:mb-1 text-gray-800 text-sm font-normal leading-5"><span class="font-bold">{{ $invitation['from'] }}</span> wants to join <div class="font-bold">{{ $invitation['subject'] }}</div></h3>
                                                    </div>
                                                </div>
                                                <div class="py-3">
                                                    <div class="flex justify-center divide-x mt-5">
                                                        <span class="flex items-center text-md px-6 rounded-md font-semibold cursor-pointer">
                                                            <x-heroicon-o-check class="w-6 h-6 mr-2" />
                                                            Accept
                                                        </span>
                                                        <span class="flex items-center text-md px-6 rounded-md font-semibold cursor-pointer">
                                                            <x-heroicon-o-x class="w-6 h-6 mr-2" />
                                                            Decline
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div x-show="activeTab===1">Sent</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function setup() {
        return {
            activeTab: 0,
            tabs: [
                'Received',
                'Sent',
            ],
            notifications: '<span class="ml-2 text-xs w-5 h-5 flex items-center justify-center text-white bg-black rounded-full">3</span>',
        }
    }
</script>
@endpush