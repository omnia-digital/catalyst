@extends('crm::livewire.layouts.pages.default-page-layout')

@section('content')
    <div class="sticky top-[55px] z-40 mb-4 rounded-b-lg pl-4 flex items-center bg-primary items-center">
        <div class="flex-1 flex items-center">
            <x-library::heading.1 class="py-4 hover:cursor-pointer">Reviews</x-library::heading.1>
        </div>
    </div>
    <div class="p-4">
        <livewire:crm::components.review-table/>
    </div>
@endsection
