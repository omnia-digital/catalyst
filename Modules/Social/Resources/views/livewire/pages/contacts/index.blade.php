@extends('social::livewire.layouts.pages.default-page-layout')

@section('content')
        <div>
            <h1 class="py-2 text-3xl">Contacts</h1>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
            @forelse (auth()->user()->followers as $item)
                <x-user-tile :user="$item->follower"/>
            @empty
                <p>No contacts to show.</p>
            @endforelse
        </div>
@endsection
