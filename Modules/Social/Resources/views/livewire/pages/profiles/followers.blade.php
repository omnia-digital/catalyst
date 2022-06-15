@extends('social::livewire.layouts.main-layout')


@section('content')
<div class="mx-auto max-w-4xl">
    <x-profiles.partials.header :user="$this->user" />
    <div class="mt-4 -ml-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
            @foreach ($this->user->followers as $item)
                <x-user-tile :user="$item->follower" class="mx-auto"  />
            @endforeach
        </div>
    </div>
</div>
@endsection
