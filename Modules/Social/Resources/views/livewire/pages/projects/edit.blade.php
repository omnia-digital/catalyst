@extends('social::livewire.layouts.main-layout')

@section('full-width-header')
    <div class="col-span-2 h-36 bg-[url('https://source.unsplash.com/random')] -mx-4 bg-cover bg-no-repeat"></div>
@endsection

@section('content')
<div>
    <!-- Page Heading -->
    <div class="space-y-8">
        <nav>
            <ol class="list-reset flex items-center">
              <li><a href="{{ route('social.my-projects') }}" class="font-bold hover:underline">My Projects</a></li>
              <li><x-heroicon-s-chevron-right class="h-4 w-4 mx-2" /></li>
              <li><a href="{{ $project->profile() }}" class="font-bold hover:underline">{{ $project->name }}</a></li>
            </ol>
        </nav>
        <div class="border-b-2 border-b-light-text-color pb-1">
            <h1 class="text-3xl"><span class="text-dark-text-color">Project Admin Page: </span><span class="text-light-text-color">{{ $project->name }}</span></h1>
        </div>
    </div>

    <div class="mt-6 flex justify-end items-center">
        <div class="mr-auto" 
            x-data="{show: false}" 
            x-show="show"
            x-transition:leave.opacity.duration.1500ms 
            x-init="@this.on('changes_saved', () => { 
                show = true; 
                setTimeout(() => { show = false; }, 3000);
            })"
            style="display: none;"
        >
            <p class="text-sm text-green-600">Project saved.</p>
        </div>
        <div class="mr-4"><a href="{{ $project->profile() }}" class="hover:underline">Cancel</a></div>
        <x-library::button.index wire:click.prevent="saveChanges">
            Save Changes
        </x-library::button.index>
    </div>
    <!-- Project Edit Navigation -->
    <div class="w-full mt-6" x-data="setup()">
        <nav class="flex items-center justify-between text-xs">
            <ul class="flex font-semibold border-b-2 border-gray-300 w-full pb-3 space-x-10 first:only:">
                <template x-for="(tab, index) in tabs" :key="tab.id">--}}
                    <li>
                        <a href="#" 
                            class="text-gray-400 transition duration-150 ease-in border-b-2 border-transparent pb-3 hover:border-dark-text-color focus:border-dark-text-color"
                            :class="(activeTab === tab.id) && 'border-dark-text-color text-dark-text-color'"
                            x-on:click.prevent="activeTab = tab.id"
                            x-text="tab.title"
                        ></a>
                    </li>
                </template>
            </ul>

        </nav>
    </div>

    <div class="mt-6 space-y-6">
        <div>
            <x-library::input.label value="Name" class="inline"/><span class="text-red-600 text-sm">*</span>
            <x-library::input.text wire:model.defer="name" required/>
            <x-library::input.error for="name"/>
        </div>
        <div>
            <x-library::input.label value="Start Date"/>
            <x-library::input.date wire:model.defer="startDate" placeholder="Pick a date"/>
            <x-library::input.error for="startDate"/>
        </div>
        <div>
            <x-library::input.label value="Summary"/>
            <x-library::input.textarea wire:model.defer="summary"/>
            <x-library::input.error for="summary"/>
        </div>
        <div>
            <x-library::input.label value="Who is this Project relevant to?"/>
            <x-library::input.text wire:model.defer="targetAudience"/>
            <x-library::input.error for="targetAudience"/>
        </div>
        <div>
            <x-library::input.label value="About this Project"/>
            <x-library::input.textarea wire:model.defer="content" :rows="8"/>
            <x-library::input.error for="content"/>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        function setup() {
            return {
                activeTab: 0,
                tabs: [
                    {
                        id: 0,
                        title: 'Basic Info',
                        component: 'social.partials.edit-project.basic'
                    },
                    {
                        id: 1,
                        title: 'Locations',
                        component: 'social.partials.edit-projects.locations'
                    }
                ],
            }
        }
    </script>
@endpush