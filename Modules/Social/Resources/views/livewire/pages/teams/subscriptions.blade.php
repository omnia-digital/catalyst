@extends('social::livewire.layouts.pages.team-profile-layout')

@section('content')
    <div class="mt-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
            @if (!$team->hasStripeConnectAccount())
                <x-library::button wire:click.prevent="connectStripe" wire:target="connectStripe">
                    Create Stripe Account
                </x-library::button>
            @elseif (!$team->stripeConnectOnboardingCompleted())
                <x-library::button wire:click.prevent="connectStripe" wire:target="connectStripe">
                    Finish Onboarding Process
                </x-library::button>
            @endif
        </div>
    </div>
@endsection
