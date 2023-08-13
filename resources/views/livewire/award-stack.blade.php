<div
    x-data="{
        openAwardsModal() {
            $dispatch('addUserAwards', {{ $user->id }})
        }
    }"
    class="flex items-center -space-x-3">
    @foreach ($awards as $award)
{{--        <span--}}
{{--            class="rounded-full bg-gray-400 border border-neutral w-10 h-10 items-center text-center vertical-center aspect-square hover:z-10 focus:z-10 active:z-10"--}}
{{--            x-tooltip="'{{ ucfirst($award->name) }}'"--}}
{{--        >--}}
            <span
            class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none  rounded-full hover:z-10 focus:z-10 active:z-10 bg-{{ $award->bg_color ??
            'neutral-dark' }} text-{{ $award->text_color ?? 'white-text-color' }}"
            x-tooltip="{{ ucfirst($award->name) }}"
        >
            <x-library::icons.icon :name="$award->icon" class="w-4"/>
            <span class="sr-only">{{ ucfirst($award->name) }}</span>
        </span>
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
