@extends('social::livewire.layouts.pages.default-page-layout')

@section('content')
    <div class="p-4">
        <h1 class="py-4 text-2xl font-bold text-dark-text-color">CRM</h1>
        <livewire:social::components.profile-table />
        <livewire:social::components.review-table />
    </div>
@endsection
