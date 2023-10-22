@php use App\Models\Team; @endphp
@extends('catalyst-social::livewire.layouts.pages.full-page-layout')

@section('content')
    <div class="md:mr-4">
        <div class="sticky top-[55px] z-40 rounded-b-lg px-4 flex items-center bg-primary items-center justify-between">
            <a href="{{ route('social.teams.home', []) }}">
                <div class="flex-1 flex items-center space-x-2 -ml-1">
                    <x-library::icons.icon name="fa-regular fa-users" size="w-8 h-8" color="text-white-text-color"/>
                    <x-library::heading.1 class="py-4"
                                          text-color="text-white-text-color">{{ $lens ? Translate::get('Teams') : Translate::get('Teams') }}
                    </x-library::heading.1>
                </div>
            </a>
            @can('create', Team::class)
                <x-library::button.index x-data=""
                                         x-on:click.prevent="$openModal('create-team')"
                                         bg-color="primary"
                                         text-color="text-primary"
                                         size="w-60 h-10" py="py-2 "
                                         class="hidden sm:block">
                    {{ Translate::get('Create Team') }}
                </x-library::button.index>
            @endcan
        </div>

        <div x-data="{}" class="px-4 sm:px-2 lg:px-0">
            @if (count($categories))
                <div class="flex justify-between space-x-2 pt-4 mb-4">
                    @foreach ($categories as $category)
                        <x-library::button.link
                                :href="route('social.teams.home', ['lens' => str($category['slug'])->slug()->value()])"
                                class="w-full h-16 {{ str($lens) == str($category['slug'])->slug()
                ->value() ? 'border-primary text-base-text-color' : 'text-base-text-color' }}">
                            {{ $category['name'] }}
                        </x-library::button.link>
                    @endforeach
                </div>
            @endif

            <!-- Filters -->
            @include('livewire.partials.filters', ['skipFilters' => ['has_attachment', 'members']])

            @if ($lens)
                <x-library::heading.2 class="pt-3">{{ str($lens)->headline() }}</x-library::heading.2>
            @endif
            <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-4">
                @forelse ($teams as $team)
                    <livewire:catalyst-social::components.teams.team-card :team="$team" wire:key="team-{{ $team->id }}"/>
                @empty
                    <p class="p-4 bg-secondary rounded-md text-base-text-color">{{ Translate::get('No Teams Found') }}</p>
                @endforelse
            </div>
            <div>
                @if ($this->hasMore())
                    <div
                            x-intersect:enter="$wire.loadMore"
                            wire:loading.attr="disabled"
                            class="mb-6 w-full relative inline-flex items-center px-4 py-2">
                        <span wire:loading wire.target="loadMore">Loading...</span>
                    </div>
                @endif
            </div>
            <livewire:teams.create-team-modal/>
            <livewire:teams.create-team-modal/>
        </div>
    </div>
@endsection
