<div class="max-w-7xl mx-auto flex flex-col md:px-8 xl:px-0 pt-20">
    <main class="flex-1">
        <div class="py-6">
            <div class="px-4 sm:px-6 md:px-0">
                <h1 class="text-2xl font-semibold text-gray-900">Projects</h1>
            </div>
            <div class="px-4 sm:px-6 md:px-0">
                <div class="grid grid-cols-3 gap-4 py-4">
                    <div class="border border-gray-200 bg-white shadow-sm rounded-md p-4 min-h-screen">
                        <x-library::heading.3>Filters</x-library::heading.3>

                        <div class="py-4 space-y-4">
                            <div>
                                <x-library::input.label>Location</x-library::input.label>
                                <x-library::input.text wire:model.defer="filters.location" placeholder="Location"/>
                            </div>

                            <div>
                                <x-library::input.label>Date</x-library::input.label>
                                <x-library::input.date wire:model.defer="filters.date" placeholder="Select Date"/>
                            </div>

                            <div>
                                <x-library::input.label>Number of Members</x-library::input.label>
                                <x-library::input.range-slider
                                        wire:model.defer="filters.members"
                                        :min="0" :max="100" :step="5" :decimals="0"
                                        showTextFields/>
                            </div>

                            <div>
                                <x-library::input.label>Rating</x-library::input.label>
                                <x-library::input.range-slider
                                        wire:model.defer="filters.rating"
                                        :min="1" :max="5" :step="1" :decimals="0" :options="['tooltips' => true]"/>
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-library::button class="w-full" wire:click="filter" wire:target="filter">
                                Show
                            </x-library::button>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div>
                            @foreach($projects as $project)
                                {{ $project->name }}
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
