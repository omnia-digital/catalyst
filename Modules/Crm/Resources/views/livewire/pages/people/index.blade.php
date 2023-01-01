@extends('crm::livewire.layouts.pages.default-page-layout')

@section('content')
    <div class="p-4">
        <x-library::heading.1 class="py-4 text-2xl font-bold text-dark-text-color">CRM</x-library::heading.1>
        <livewire:crm::components.profile-table/>
    </div>
@endsection
