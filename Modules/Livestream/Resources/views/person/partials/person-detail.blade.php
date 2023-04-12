<div>
    <!-- Sidebar -->
    <aside class="hidden w-96 bg-white p-8 border-l border-gray-200 overflow-y-auto lg:block">
        @livewire('person.person-info-panel', ['personId' => $selectedPerson])
    </aside>

    <!-- Slide over - Only for mobile -->
    <div class="lg:hidden">
        <x-slide-over eventSlideOverClosed="person-deselected" :show="!empty($selectedPerson)" disableCloseOnClickAway>
            @livewire('person.person-info-panel', ['personId' => $selectedPerson])
        </x-slide-over>
    </div>
</div>
