@extends('social::livewire.layouts.main-layout')


@section('content')
<x-teams.partials.header  :team="$team" />
<div class="mt-4 -mx-4">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
        @foreach ($team->followers as $item)
            <x-user-tile :user="$item->follower"  />
        @endforeach
    </div>
</div>
@endsection
