@extends('social::livewire.layouts.main-layout')

@section('content')
<div class="p-4">
    <div class="text-lg font-bold text-dark-text-color">
        <h1>Contacts</h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
        @foreach (auth()->user()->followers as $item)
            <livewire:social::user-tile :user="$item->followable"  />
        @endforeach
    </div>
</div>
@endsection