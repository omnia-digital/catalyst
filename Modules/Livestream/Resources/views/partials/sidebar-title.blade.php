<div class="flex md:justify-center text-gray-400 w-full pt-2 px-3 rounded-md items-center text-center text-xs font-medium">
    @if ($icon)
        <x-dynamic-component component="{{ $icon }}" class="text-gray-500 h-6 w-6"/>
    @endif

    <h5 class="mt-2 text-center items-center flex">{{ strtoupper($name) }}</h5>
</div>
