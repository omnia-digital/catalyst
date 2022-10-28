@extends('social::livewire.layouts.pages.user-profile-layout')


@section('content')
    <x-profiles.partials.header :user="$this->user"/>
    <div class="mt-4 -ml-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
            @foreach ($this->user->followers as $item)
                <x-user-tile :user="$item->follower" class="mx-auto"/>
            @endforeach
        </div>
    </div>
@endsection
