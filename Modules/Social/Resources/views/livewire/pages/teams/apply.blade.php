@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
<div class="min-h-screen">
    <div class="mt-8">
        <x-library::heading.2 class="text-center">{{ \Trans::get( $team->name . ' Application') }}</x-library::heading.2>
    </div>
    <livewire:forms::team-application-form 
        :form="$applicationForm" 
        :team_id="$team->id" 
        submitText="Apply" 
    />
</div>
@endsection
