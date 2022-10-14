<div
    x-data="{
        openAwardsModal() {
            this.$wire.emitUp('addUserAwards', {{ $user->id }})
        }
    }"
    class="flex items-center -space-x-3">
    @foreach ($awards as $award)
        <div
            class="rounded-full bg-gray-400 border border-neutral p-2 hover:z-10 focus:z-10 active:z-10"
            x-tooltip="'{{ ucfirst($award->name) }}'"
        >
            <x-library::icons.icon :name="$award->icon" class="h-3 w-3"/>
            <span class="sr-only">{{ ucfirst($award->name) }}</span>
        </div>
    @endforeach
    @can('add-award-to-team-member', $team)
        <div
            x-on:click.prevent="openAwardsModal"
            class="rounded-full bg-white border border-neutral p-2 cursor-pointer"
            x-tooltip="'{{ \Trans::get('Add Award') }}'"
        >
            <x-heroicon-o-plus class="h-3 w-3" />
            <span class="sr-only">{{ \Trans::get('Add Award') }}</span>
        </div>
    @endcan
</div>
