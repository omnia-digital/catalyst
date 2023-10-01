<div class="py-12">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <x-panel-header click="$toggle('addPersonModalOpen')" title=" Person" icon="heroicon-o-plus"/>

            <!-- Filters -->
            @include('person.partials.filters')

            <div class="flex-1 flex items-stretch overflow-hidden">
                <!-- List of People -->
                <main class="flex-1 overflow-y-auto">
                    <div class="pt-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex">
                            <div class="mr-6 bg-gray-100 p-0.5 rounded-lg flex items-center sm:hidden">
                                <button wire:click="switchLayout('list')" type="button"
                                        class="p-1.5 rounded-md text-gray-400 {{ $this->isUsingListLayout() ? 'bg-white' : 'hover:bg-white' }} hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                    <x-heroicon-s-view-list class="h-5 w-5"/>
                                    <span class="sr-only">Use list view</span>
                                </button>
                                <button wire:click="switchLayout('grid')" type="button"
                                        class="ml-0.5 {{ $this->isUsingGridLayout() ? 'bg-white' : 'hover:bg-white' }} p-1.5 rounded-md shadow-sm text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                    <x-heroicon-s-view-grid class="h-5 w-5"/>
                                    <span class="sr-only">Use grid view</span>
                                </button>
                            </div>
                            <div class="flex-1 sm:hidden">
                                <label for="sort-by" class="sr-only">Sort By</label>
                                <select wire:model.live="orderBy" id="sort-by" name="tabs"
                                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="first_name">Name</option>
                                    <option value="created_at">Created At</option>
                                </select>
                            </div>
                        </div>

                        <!-- Sort By menu for mobile -->
                        <div>
                            <div class="hidden sm:block">
                                <div class="flex items-center border-b border-gray-200">
                                    <nav class="flex-1 -mb-px flex space-x-6 xl:space-x-8" aria-label="Tabs">
                                        <p class="border-transparent text-gray-500 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                            Sort By: </p>
                                        <x-person.sort-button key="first_name" :orderBy="$orderBy">
                                            Name
                                        </x-person.sort-button>

                                        <x-person.sort-button key="created_at" :orderBy="$orderBy">
                                            Created At
                                        </x-person.sort-button>
                                    </nav>
                                    <div class="hidden ml-6 bg-gray-100 p-0.5 rounded-lg items-center sm:flex">
                                        <button wire:click="switchLayout('list')" type="button"
                                                class="p-1.5 rounded-md text-gray-400 {{ $this->isUsingListLayout() ? 'bg-white' : 'hover:bg-white' }} hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                            <x-heroicon-s-view-list class="h-5 w-5"/>
                                            <span class="sr-only">Use list view</span>
                                        </button>
                                        <button wire:click="switchLayout('grid')" type="button"
                                                class="ml-0.5 {{ $this->isUsingGridLayout() ? 'bg-white' : 'hover:bg-white' }} p-1.5 rounded-md shadow-sm text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                            <x-heroicon-s-view-grid class="h-5 w-5"/>
                                            <span class="sr-only">Use grid view</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <section class="mt-8 pb-16" aria-labelledby="gallery-heading">
                            @if ($people->count() > 0)
                                @if ($this->isUsingGridLayout())
                                    <ul role="list"
                                        class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6  md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 xl:gap-x-8">
                                        @foreach ($people as $person)
                                            <x-person.grid-item
                                                    wire:key="person-{{ $person->id }}"
                                                    wire:click="selectPerson({{ $person->id }})"
                                                    :person="$person"
                                                    :selected="$person->id === $selectedPerson"
                                            />
                                        @endforeach
                                    </ul>
                                @else
                                    <ul class="mt-3 grid grid-cols-1 gap-5 sm:gap-6">
                                        @foreach ($people as $person)
                                            <x-person.list-item
                                                    wire:key="person-{{ $person->id }}"
                                                    wire:click="selectPerson({{ $person->id }})"
                                                    :person="$person"
                                                    :selected="$person->id === $selectedPerson"
                                            />
                                        @endforeach
                                    </ul>
                                @endif
                            @else
                                <x-person.empty/>
                            @endif
                        </section>

                        <div class="pb-6">
                            {{ $people->onEachSide(1)->links() }}
                        </div>
                    </div>
                </main>

                <!-- Person Detail -->
                @include('person.partials.person-detail', ['selectedPerson' => $selectedPerson])
            </div>
        </div>
    </div>

    <x-dialog-modal wire:model.live="addPersonModalOpen">
        <x-slot name="title">Add Person</x-slot>
        <x-slot name="content">
            <div>
                <x-input.label value="First Name" required/>
                <x-input.text id="name" wire:model="person.first_name" placeholder="First Name"/>
                <x-input-error for="person.first_name" class="mt-2"/>
            </div>
            <div class="mt-4">
                <x-input.label value="Last Name" required/>
                <x-input.text id="name" wire:model="person.last_name" placeholder="Last Name"/>
                <x-input-error for="person.last_name" class="mt-2"/>
            </div>
            <div class="mt-4">
                <x-input.label value="Email" required/>
                <x-input.text type="email" id="email" wire:model="person.email" placeholder="{{ __('Email') }}"/>
                <x-input-error for="person.email" class="mt-2"/>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('addPersonModalOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ml-2" wire:click="addPerson" wire:loading.attr="disabled">
                {{ __('Add Person') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
