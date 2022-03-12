@extends('social::livewire.layouts.main-layout')

@section('content')
<div class="divide-y">
    <livewire:social::post-list-item :post="$post" :wire:key="'parent-post-' . $post->id" />
    <ul role="list" class="mt-4 pt-4 space-y-4">
       @if ($recentlyAddedComment)
           <li role="listitem">
               <livewire:social::post-list-item :post="$recentlyAddedComment" :wire:key="$recentlyAddedPost->id" />
           </li>
       @endif
       @foreach ($post->comments()->latest()->get() as $comment)
           <li role="listitem">
            <livewire:social::post-list-item :post="$comment" :wire:key="$comment->id" />
            @if ($comment->comments()->exists())
                <ul class="ml-12 mt-4">
                    @foreach ($comment->comments()->oldest()->get() as $reply)
                        <li class="mt-4">
                            <livewire:social::post-list-item :post="$reply" :wire:key="$reply->id" />
                        </li>
                            
                    @endforeach
                </ul>
                   
            @endif 
           </li>
       @endforeach
   </ul>
</div>
@endsection