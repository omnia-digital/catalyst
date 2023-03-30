<a href="{{ $to }}" class="{{ $isSelected ? 'bg-blue-500 text-white' : 'text-blue-500 hover:bg-blue-500 hover:text-white' }} group py-2 px-3 rounded-md flex items-center text-sm font-medium">
    @if ($icon)
        <x-dynamic-component component="{{ $icon }}" class="{{ $isSelected ? 'text-white' : 'text-blue-500 group-hover:text-white' }} mr-3 h-6 w-6"/>
    @endif

    <span>{{ $name }}</span>
</a>
