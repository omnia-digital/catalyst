<div class="md:col-span-1 flex justify-between">
    <div class="px-4 sm:px-0">
        <x-library::heading.3 class="text-lg font-medium text-dark-text-color">{{ $title }}</x-library::heading.3>

        <p class="mt-1 text-sm text-base-text-color">
            {{ $description }}
        </p>
    </div>

    <div class="px-4 sm:px-0">
        {{ $aside ?? '' }}
    </div>
</div>
