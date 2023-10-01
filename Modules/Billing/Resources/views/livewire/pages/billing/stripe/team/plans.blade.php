@php use App\Enums\Teams\TeamBillingPeriod; @endphp
@extends('social::livewire.layouts.pages.team-profile-layout')

@section('content')
    <div class="mt-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-4">
            <x-library::table>
                <x-slot name="head">
                    <x-tables::row>
                        <x-library::table.head>Name</x-library::table.head>
                        <x-library::table.head>Created At</x-library::table.head>
                        <x-library::table.head>Updated At</x-library::table.head>
                    </x-tables::row>
                </x-slot>

                <x-slot name="body">
                    @foreach ($plans as $plan)
                        <x-tables::row>
                            <x-library::table.cell>
                                <p>{{ $plan->name }}</p>
                                <p>{{ $plan->description }}</p>
                            </x-library::table.cell>
                            <x-library::table.cell>
                                {{ $plan->created_at->diffForHumans() }}
                            </x-library::table.cell>
                            <x-library::table.cell>
                                {{ $plan->updated_at->diffForHumans() }}
                            </x-library::table.cell>
                        </x-tables::row>
                    @endforeach
                </x-slot>
            </x-library::table>

            <div class="space-y-4">
                <x-library::heading.3>Add New Plan</x-library::heading.3>

                <div>
                    <x-library::input.label value="Name"/>
                    <x-library::input.text id="name" wire:model="name" placeholder="Name"/>
                    <x-library::input.error for="name"/>
                </div>

                <div>
                    <x-library::input.label value="Description"/>
                    <x-library::input.textarea id="description" wire:model="description"
                                               placeholder="Description"/>
                    <x-library::input.error for="description"/>
                </div>

                <div>
                    <x-library::input.label value="Price"/>
                    <x-library::input.text type="number" id="price" wire:model="price" placeholder="Price"/>
                    <x-library::input.error for="price"/>
                </div>

                {{--                <div>--}}
                {{--                    <x-library::input.label value="Recurring"/>--}}
                {{--                    <x-library::input.toggle />--}}
                {{--                    <x-library::input.label value="One time"/>--}}
                {{--                </div>--}}

                <div>
                    <x-library::input.label value="Billing Period"/>
                    <x-library::input.select id="billing-period" wire:model="billingPeriod"
                                             :options="TeamBillingPeriod::options()"/>
                    <x-library::input.error for="billingPeriod"/>
                </div>

                <div class="text-right">
                    <x-library::button wire:click.prevent="addNewPlan" wire:target="addNewPlan">Add New Plan
                    </x-library::button>
                </div>
            </div>
        </div>
    </div>
@endsection
