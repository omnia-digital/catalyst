@extends('social::livewire.layouts.main-layout')

@section('content')
<div class="divide-y">
    {{ $profile->user->name }}

    <ul role="list" class="mt-4 pt-4 space-y-4">
       @foreach ($profile?->user?->posts as $post)
           <li role="listitem">
            <livewire:social::post-list-item :post="$post" :wire:key="$post->id" />
            @if ($post->comments()->exists())
                <ul class="ml-12 mt-4">
                    @foreach ($post->comments()->oldest()->get() as $comment)
                        <li class="mt-4">
                            <livewire:social::post-list-item :post="$comment" :wire:key="$comment->id" />
                        </li>
                    @endforeach
                </ul>
            @endif
           </li>
       @endforeach
   </ul>
</div>
@endsection
