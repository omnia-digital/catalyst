<div class="flex-1 h-12 border -mt-px -ml-px flex items-center justify-center bg-indigo-100 text-gray-900"
        {{-- style="min-width: 10rem;" --}}>
    @php
        $dayOfWeek = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
    @endphp
    <p class="text-sm hidden lg:block">
        {{ $day->format('l') }}
    </p>
    <p class="text-sm hidden md:block lg:hidden">
        {{ $day->format('D') }}
    </p>
    <p class="text-sm block md:hidden">
        {{ $dayOfWeek[$day->format('w')] }}
    </p>
</div>
