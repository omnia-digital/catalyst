@extends('crm::livewire.layouts.pages.full-page-layout')

@section('content')
    <div class="sticky top-[55px] z-40 mb-4 rounded-b-lg pl-4 flex items-center bg-primary items-center">
        <div class="flex-1 flex items-center">
            <x-library::heading.1 class="py-4 hover:cursor-pointer">Contacts</x-library::heading.1>
        </div>
    </div>
    <div class="pr-4">
        {{--        <x-library::heading.2>Profiles</x-library::heading.2>--}}
        <livewire:crm::components.profile-table/>
    </div>
@endsection
