<div x-data="{ open: false }" class="{{ $class }} hidden lg:block fixed md:w-64 sm:pl-6 sm:pt-4">
    <!-- Static \sidebar for desktop -->
    <div class="hidden md:flex md:flex-col scrollbar-hide md:sticky top-20 md:inset-y-2">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex flex-col min-h-0 space-y-4">
            <livewire:partials.profile-badge/>

            <hr class="mr-6 border-gray-300"/>
            <div class="flex mb-4">
                <nav class="space-y-3">
                    @foreach ($navigation as $item)
                        @if(\Platform::isModuleEnabled($item['module']))
                            <a href="{{ route($item['name']) }}"
                               title="{{ $item['label'] }}"
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

            {{--            <livewire:social::partials.applications/>--}}
        </div>
    </div>
</div>
