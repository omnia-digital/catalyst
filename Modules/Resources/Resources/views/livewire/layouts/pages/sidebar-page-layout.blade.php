@extends('social::livewire.layouts.main-layout')


@section('page-layout')
    <div class="flex space-x-4">
        <div class=" w-full">
            @yield('content')
        </div>
        <x-sidebar-column class="max-w-sm" type="{{\Modules\Social\Enums\PostType::RESOURCE->value}}"/>
    </div>
@endsection
