<div>
    @if ($person)
        <div>
            <div class="pb-16 space-y-6">
                <div>
                    <div class="mt-4 flex items-start justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">{{ $person->name }}</h2>
                        </div>
                        <button wire:click="showEditModal" type="button" class="ml-4 bg-white rounded-full h-8 w-8 flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <x-heroicon-s-pencil class="h-5 w-5"/>
                            <span class="sr-only">Add description</span>
                        </button>
                    </div>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900">Details</h3>

                    <div class="mt-2 flex items-center justify-between">
                        <p class="text-sm text-gray-500 italic">{{ $person->first_name }}</p>
                    </div>
                    <div class="mt-2 flex items-center justify-between">
                        <p class="text-sm text-gray-500 italic">{{ $person->last_name }}</p>
                    </div>
                    <div class="mt-2 flex items-center justify-between">
                        <p class="text-sm text-gray-500 italic">{{ $person->email }}</p>
                    </div>
                </div>

                <h3 class="text-red-600 font-bold">Danger Zone</h3>
                <div class="grid grid-cols-1 gap-2">
{{--                    <livewire:person.move-person :person="$person"/>--}}
                    <livewire:person.delete-person :person="$person"/>
                </div>
            </div>

            <!-- Edit modal -->
            @include('person.partials.edit-person-modal', ['state' => $state])
        </div>
    @else
        <div class="p-16">
            <x-heroicon-s-information-circle class="w-8 h-8 text-gray-400 mx-auto mb-2"/>
            <h2 class="font-medium text-gray-400 text-center">Please select an person to show detail.</h2>
        </div>
    @endif
</div>
