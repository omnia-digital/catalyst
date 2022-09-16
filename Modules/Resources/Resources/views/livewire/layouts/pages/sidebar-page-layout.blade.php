@extends('social::livewire.layouts.main-layout')


@section('page-layout')
    <div class="grid grid-cols-12 gap-4 mr-4">
        <div class="col-span-8 2xl:col-span-9">
            @yield('content')
        </div>
        <x-sidebar-column class="hidden sm:block col-span-4 2xl:col-span-3" type="{{\Modules\Social\Enums\PostType::RESOURCE->value}}"/>
    </div>
@endsection
