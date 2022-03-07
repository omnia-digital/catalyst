<div class="bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:p-6 flex justify-between">
        <div class="mt-2 sm:items-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ $title }}
            </h3>
            <div class="mt-3 max-w-xl text-sm leading-5 text-gray-500">
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