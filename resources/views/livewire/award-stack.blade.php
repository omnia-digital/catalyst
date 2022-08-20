<div x-data class="flex items-center -space-x-3">
    @foreach ($awards as $award)
        <div 
            class="rounded-full bg-gray-400 border border-neutral p-2 hover:z-10 focus:z-10 active:z-10"
            x-tooltip="'{{ ucfirst($award->name) }}'"
        >
            <x-dynamic-component :component="$award->icon" class="h-3 w-3" />
            <span class="sr-only">{{ ucfirst($award->name) }}</span>
        </div>
    @endforeach
    @can('add-award-to-team-member', $team)
        <div 
            x-on:click.prevent="$openModal('add-awards-modal-{{ $user->id }}')"  
            class="rounded-full bg-white border border-neutral p-2 cursor-pointer"
            x-tooltip="'{{ \Trans::get('Add Award') }}'"
        >
            <x-heroicon-o-plus class="h-3 w-3" />
            <span class="sr-only">{{ \Trans::get('Add Award') }}</span>
        </div>
    @endcan
    <x-library::modal id="add-awards-modal-{{ $user->id }}" maxWidth="2xl">
        <x-slot name="title">{{ \Trans::get('Add Awards') }}</x-slot>
        <x-slot name="content">
            <div class="w-full flex flex-col">
                @forelse (\App\Models\Award::whereNotIn('id', $user->awards()->pluck('awards.id')->toArray())->get() as $award)
                    <div class="mr-4 mt-2 flex items-center">
                        <input type="checkbox" wire:model.defer="awardsToAdd" value="{{ $award->id }}" class="mr-2" name="award-item-{{ $award->id }}" id="award-item-{{ $award->id }}">
                        <label for="award-item-{{ $award->id }}" class="bg-primary p-2 flex flex-1 items-center">
                            <x-dynamic-component :component="$award->icon" class="h-4 w-4 mr-4" />
                            <p>{{ ucfirst($award->name) }}</p>
                        </label>
                    </div>
                @empty
                    <div class="w-full px-4 py-2 text-sm bg-white p-2 flex items-center">
                        <p>{{ \Trans::get('No other awards are available') }}</p>
                    </div>
                @endforelse

            </div>
        </x-slot>
        <x-slot name="actions">
            <x-library::button wire:click="addAward({{ $user->id }})">{{ Trans::get('Add') }}</x-library::button>
        </x-slot>
    </x-library::modal>
</div>
