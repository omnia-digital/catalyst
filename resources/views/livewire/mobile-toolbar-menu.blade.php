<div x-data="{ open: false }" class="{{ $class }} block lg:hidden">
    <div class="fixed bottom-0 bg-white z-[70] w-full px-4">
        <div class="flex justify-around">
            @foreach (collect($navigation)->take(4) as $item)
                @if (\Platform::isModuleEnabled($item['module']))
                    <a href="{{ route($item['name']) }}"
                       class="{{ request()->routeIs($item['name']) ? 'text-primary' : 'text-light-text-color hover:text-white-text-color' }} {{
                               'group text-center
                               text-base-text-color py-3' }}">
                        <div class="text-xs font-medium text-center py-0 leading-2">
                            <x-library::icons.icon name="{{ $item['icon'] }}" size="w-8 h-8" class="{{ request()->routeIs($item['name']) ? 'text-primary' : 'text-light-text-color
                        group-hover:text-light-text-color' }} inline text-center"/>
                            <br/>
                            <span class="{{ request()->routeIs($item['name']) ? 'text-primary' : 'text-light-text-color group-hover:text-light-text-color' }} text-center inline"
                            >{{ $item['label'] }}</span>
                        </div>
                    </a>
                @endif
            @endforeach
            <!-- mobile menu button -->
            <a @click="open = true"
               class="{{ request()->routeIs($item['name']) ? 'text-primary' : 'text-light-text-color hover:text-white-text-color' }} {{
                               'group text-center
                               text-base-text-color py-3' }}">
                <div class="text-xs font-medium text-center py-0 leading-2">
                    <x-library::icons.icon name="heroicon-o-menu" size="w-8 h-8" class="text-light-text-color
                        group-hover:text-light-text-color inline text-center"/>
                    <br/>
                    <span class="text-light-text-color group-hover:text-light-text-color text-center inline"
                    >{{ Trans::get('Menu') }}</span>
                    <span class="sr-only">Open sidebar</span>
                </div>
            </a>
        </div>
    </div>

    <!-- mobile slideout sidebar -->
    <div
            x-show="open" @click.away="open = false"
            x-transition:enter.duration.100ms
            x-transition:leave.duration.75ms
    >
        <div class="relative inset-0 z-[900] md:hidden">
            <div aria-hidden="true" class="sticky inset-0 bg-secondary bg-opacity-75"></div>
            <div class="fixed flex flex-col max-w-lg w-full py-2 bg-secondary">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button type="button"
                            class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            tabindex="0"
                            @click="open = false"
                    >
                        <span class="sr-only">Close sidebar</span>
                        <x-heroicon-o-x class="h-6 w-6 text-white-text-color"/>
                    </button>
                </div>
                <div class="flex-1 h-0 overflow-y-auto">
                    <!-- mobile nav -->
                    <nav class="px-2 space-y-1">
                        @foreach ($navigation as $item)
                            @if (!empty($item['module']))
                                @if (\Platform::isModuleEnabled($item['module']))
                                    <a href="{{ Route::has($item['name']) ? route($item['name']) : $item['name'] }}"
                                    class="{{ request()->routeIs($item['name']) ? 'font-semibold text-base-text-color' : 'text-light-text-color hover:text-dark-text-color' }}
                                            {{ 'w-full py-2 group flex justify-left items-center text-xl space-x-2 font-medium' }}"
                                    aria-current="page">
                                        <x-library::icons.icon name="{{ $item['icon'] }}" size="w-6 h-6 mr-1"/>
                                        <span>{{ $item['label'] }}</span>
                                    </a>
                                @endif
                            @else
                                <a href="{{ Route::has($item['name']) ? route($item['name']) : $item['name'] }}"
                                   class="{{ request()->routeIs($item['name']) ? 'font-semibold text-base-text-color' : 'text-light-text-color hover:text-dark-text-color' }}
                                            {{ 'w-full py-2 group flex justify-left items-center text-xl space-x-2 font-medium' }}"
                                   aria-current="page">
                                    <x-library::icons.icon name="{{ $item['icon'] }}" size="w-6 h-6 mr-1"/>
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            @endif
                        @endforeach
                    </nav>
                </div>
            </div>
            <div class="flex-shrink-0 w-14" aria-hidden="true">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>
</div>
