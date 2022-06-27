@extends('social::livewire.layouts.main-layout')

@section('content')
<div class="p-4">
    <div>
        <h1 class="text-2xl font-bold text-dark-text-color">CRM</h1>
    </div>
{{--    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">--}}
{{--        @forelse (auth()->user()->followers as $item)--}}
{{--            <x-user-tile :user="$item->follower"  />--}}
{{--        @empty--}}
{{--            <p>No contacts to show.</p>--}}
{{--        @endforelse--}}
{{--    </div>--}}
    {{ $this->table }}
</div>
@endsection
