@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
<div class="min-h-screen">
    <livewire:forms::team-application-form 
        :form="$applicationForm" 
        :team_id="$team->id" 
        submitText="Apply" 
    />
</div>
@endsection
