@extends('social::livewire.layouts.main-layout')


@section('content')
<div class="flex space-x-4">
    <div class="mx-auto max-w-4xl">
        @yield('main-content')
    </div>
    @yield('sidebar')
</div>
@endsection
