<div class="max-w-7xl mx-auto flex flex-col md:px-8 xl:px-0 pt-20">
    <main class="flex-1">
        <div class="py-6">
            <div class="px-4 sm:px-6 md:px-0">
                <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
            </div>
            <div class="px-4 sm:px-6 md:px-0">
                <div class="grid grid-cols-3 gap-4 py-4">
                    <div class="border border-gray-200 bg-white shadow-sm rounded-md p-4">
                        <x-library::heading.3>Filters</x-library::heading.3>
                    </div>
                    <div class="col-span-2">
                        <ul role="list" class="space-y-4">
                            @foreach($projects as $project)
                                <li>
                                    <livewire:resources::components.resource-card
                                            as="li"
                                            :post="$project"/>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
