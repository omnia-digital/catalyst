@props([
    'episodes' => [],
    'episodesCount' => 0
])

<div class="p-4">
    <h2 class="font-medium text-gray-400 text-center">Selected Episodes ({{ $episodesCount }})</h2>

    <ul class="mt-4 overflow-y-auto">
        @foreach ($episodes as $key => $episode)
            <li class="flex justify-between items-center">
                <span>{{ $episode->title }}</span>
                <x-heroicon-s-x wire:click="multiDeselect('{{ $episode->id }}')" class="w-6 h-6 flex-shrink-0 text-gray-400 hover:text-red-600 cursor-pointer" />
            </li>
        @endforeach
    </ul>
    <div class="mt-24">
        <h3 class="text-red-600 font-bold">Danger Zone</h3>
        <div class="mt-4">
            <livewire:episode.delete-multiple-episodes :episodeIDs="$episodes->pluck('id')->toArray()"/>
        </div>
    </div>
</div>