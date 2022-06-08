@extends('social::livewire.layouts.main-layout')


@section('content')
<livewire:social::pages.projects.partials.header :team="$team" />
<div class="mt-4 -mx-4">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
        @foreach ($team->followers as $item)
            <livewire:social::user-tile :user="$item->followable"  />
        @endforeach
    </div>
</div>
@endsection
