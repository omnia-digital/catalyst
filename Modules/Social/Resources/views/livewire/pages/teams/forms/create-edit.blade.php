@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
<div class="min-h-screen">
    <form wire:submit.prevent="save({{ $this->team->id }})" class="p-8 space-y-8 max-w-4xl mx-auto">
        <div class="p-8">
            {{ $this->form }}
        </div>

        <x-forms::button wire:loading.attr="disabled" wire:target="save" class="bg-black" type="submit">
            <span wire:loading.remove wire:target="save" class="text-white">Save</span>
            <span wire:loading wire:target="save">Saving...</span>
        </x-forms::button>
    </form>
</div>
@endsection
