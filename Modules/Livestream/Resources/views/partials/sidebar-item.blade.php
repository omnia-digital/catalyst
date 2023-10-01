<a href="{{ $to }}"
   class="{{ $isSelected ? 'bg-blue-500 text-white' : 'text-blue-500 hover:bg-blue-500 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    @if ($icon)
        <x-dynamic-component component="{{ $icon }}"
                             class="{{ $isSelected ? 'text-white' : 'text-blue-500 group-hover:text-white' }} h-6 w-6"/>
    @endif
    <span class="ml-2 text-center">{{ $name }}</span>
</a>
