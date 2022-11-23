<div>
    <div class="flex justify-between items-center mb-8">
        <div class="text-4xl">
            <span class="font-bold">{{ $startsAt->englishMonth }}</span>
            <span>{{ $startsAt->year }}</span>
        </div>
        <div>
            <button class="text-light-text-color hover:text-primary active:text-primary focus:text-primary"
                wire:click="goToPreviousMonth"
            >
                <x-heroicon-o-chevron-left class="w-8 h-8" />
            </button>
            <button class="text-light-text-color hover:text-primary active:text-primary focus:text-primary"
                wire:click="goToNextMonth"
            >
                <x-heroicon-o-chevron-right class="w-8 h-8" />
            </button>
        </div>
    </div>
</div>