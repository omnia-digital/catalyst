<div class="bg-secondary shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:p-6 flex justify-between">
        <div class="mt-2 sm:items-center">
            <x-library::heading.3 class="text-lg leading-6 font-medium text-dark-text-color">
                {{ $title }}
            </x-library::heading.3>
            <div class="mt-3 max-w-xl text-sm leading-5 text-base-text-color">
                <p>{{ $description }}</p>
            </div>
        </div>
        <div class="flex items-center">
            <span class="inline-flex rounded-md shadow-sm">
                {{ $action }}
            </span>
        </div>
    </div>
</div>
