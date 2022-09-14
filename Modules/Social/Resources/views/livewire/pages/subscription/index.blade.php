@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
    <div x-data="" class="">
        <div class="mt-0">
            <x-social::page-heading>
                <x-slot name="title">{{ \Trans::get('Subscription') }}</x-slot>
                Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.
            </x-social::page-heading>
            
            <!-- Subscription Settings -->
            <div class="mt-6 space-y-6">
                <div class="grid grid-cols-4 items-center max-w-3xl">
                    <div class="col-span-2 px-2 py-4">
                        <p>Subscription Status</p>
                    </div>
                    <div class="col-span-1 px-2 py-4">
                        @if ($this->subscriptionActive)
                            <span class="inline-flex items-center px-4 py-px rounded-full font-bold text-white bg-success-600">Active</span>
                        @else
                            <span class="inline-flex items-center px-4 py-px rounded-full font-bold text-white bg-danger-600">Inactive</span>
                        @endif
                    </div>
                    <div class="col-span-1 px-2 py-4">
                        @if ($this->subscriptionActive)
                            <a role="button" wire:click="confirmSubscriptionCancellation" class="font-semibold text-secondary hover:underline whitespace-nowrap">Cancel Subscription</a>
                        @else
                            <a role="button" x-on:click.prevent="$openModal('subscription-form')" class="font-semibold text-secondary hover:underline whitespace-nowrap">New Subscription</a>
                        @endif
                    </div>

                    <div class="col-span-2 px-2 py-4 border-t">
                        <p>Email Address</p>
                    </div>
                    <div class="col-span-2 px-2 py-4 border-t">
                        <p>{{ $this->user->email }}</p>
                    </div>

                    <div class="col-span-2 px-2 py-4 border-t">
                        <p>Subscription Type</p>
                    </div>
                    <div class="col-span-2 px-2 py-4 border-t">
                        <p>{{ $this->subscription?->type?->name ?? 'N/A' }}</p>
                    </div>

                    <div class="col-span-2 px-2 py-4 border-t">
                        <p>Amount</p>
                    </div>
                    <div class="col-span-2 px-2 py-4 border-t">
                        <p>{{ $this->subscription?->type?->printAmount() ?? 'N/A' }}</p>
                    </div>

                    <div class="col-span-2 px-2 py-4 border-t">
                        <p>Next Invoice</p>
                    </div>
                    <div class="col-span-2 px-2 py-4 border-t">
                        <p>{{ $this->subscription?->next_invoice_at?->toFormattedDateString() ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('modals')
<x-library::modal id="subscription-form" maxWidth="4xl" hideCancelButton>
    <x-slot name="title">{{ \Trans::get('New Subscription') }}</x-slot>

    <x-slot name="content">
        <iframe src="{{ $this->iFrameURL() }}" width="100%" height="100%" frameborder="0" ></iframe>
        <script src="//tfaforms.com/js/iframe_resize_helper.js"></script>
    </x-slot>
</x-library::modal>
<!-- Cancel Subscription Confirmation Modal -->
<x-jet-confirmation-modal wire:model="confirmingSubscriptionCancellation">
    <x-slot name="title">
        {{ \Trans::get('Cancel Subscription') }}
    </x-slot>

    <x-slot name="content">
        {{ \Trans::get('Are you sure you would like to cancel your subscription?') }}
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('confirmingSubscriptionCancellation')" wire:loading.attr="disabled">
            {{ \Trans::get('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-danger-button class="ml-2" wire:click="cancelSubscription" wire:loading.attr="disabled">
            {{ \Trans::get('Confirm') }}
        </x-jet-danger-button>
    </x-slot>
</x-jet-confirmation-modal>
@endpush
