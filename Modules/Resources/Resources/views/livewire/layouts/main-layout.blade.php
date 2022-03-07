<div>
    <livewire:resources::layouts.module-navigation/>

    <div class="min-h-screen md:ml-24 md:pt-8 md:pr-6 md:pl-6 bg-gray-100">
        <div class="flex justify-between items-center">
            <div class="flex-1 flex items-center">
                <h1 class="py-4 text-3xl">Resources</h1>
{{--                <x-heroicon-o-cog class="mt-1 ml-3 w-6 h-6"/>--}}
            </div>

            <x-library::button x-data="" class="py-2 w-60 h-10" x-on:click.prevent="$openModal('add-resource-modal')">
                Add Resource
            </x-library::button>
        </div>

        <div class="">
            <!-- Page content -->
            <div class="mx-auto">
                @yield('content')
            </div>
        </div>
        <livewire:resources::components.add-resource-modal/>
    </div>
</div>

