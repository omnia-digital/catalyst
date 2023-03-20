<div wire:click.prevent.stop="showPost"
     class="w-full bg-secondary rounded group relative bg-black hover:cursor-pointer hover:ring-1 hover:ring-black"
     style="background-image: url({{ $post->media?->first()?->getUrl() ? $post->media?->first()?->getUrl() : config('teams.defaults.cover_photo') }}); background-size: cover;
     background-repeat:
     no-repeat;"
>
    <div class="h-80 rounded"></div>
</div>
