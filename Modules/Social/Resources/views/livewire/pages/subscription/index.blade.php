@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
    <div x-data="setup()" class="">
        <div class="mt-0">
            <x-social::page-heading>
                <x-slot name="title">{{ \Trans::get('Subscription') }}</x-slot>
                Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.
            </x-social::page-heading>
            
            <!-- Subscription Settings -->
            <div class="mt-6 space-y-6">
                <div class="grid grid-cols-4 items-center max-w-2xl">
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
                            <a href="#" class="font-semibold text-secondary hover:underline">Cancel Subscription</a>
                        @else
                            <a role="button" x-on:click.prevent="$openModal('subscription-form')" class="font-semibold text-secondary hover:underline">New Subscription</a>
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
        {!! $this->subscriptionForm !!}
    </x-slot>
</x-library::modal>

@endpush
