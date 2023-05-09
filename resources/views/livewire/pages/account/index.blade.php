@extends('social::livewire.layouts.pages.account-page-layout')

@section('content')
    <x-social::page-heading>
        <x-slot name="title">{{ \Trans::get('Account Settings') }}</x-slot>
        {{ Trans::get('Manage all your account settings in one place.') }}
    </x-social::page-heading>
    <x-vertical-tabs>
        <x-slot:items>
            <x-vertical-tabs.item icon="cog" class="text-lg font-medium">Account</x-vertical-tabs.item>
            <x-vertical-tabs.item icon="bell" class="text-lg font-medium">Notification Settings</x-vertical-tabs.item>
        </x-slot:items>
        <x-slot:panels>
            <x-vertical-tabs.panel>
                <x-slot:title>{{ Trans::get('Account') }}</x-slot:title>
                <x-slot:description>Change your account settings.</x-slot:description>
                <div class="mt-6 grid grid-cols-4 gap-6">
                    <div class="col-span-4 sm:col-span-2">
                        <x-library::input.label value="Email" class="inline"/>
                        <span class="text-red-600 text-sm">*</span>
                        <x-library::input.text id="email" wire:model.defer="email" required/>
                        <x-library::input.error for="email"/>
                    </div>
                    <div class="col-span-4 sm:col-span-2">
                        <x-library::input.label value="Username" class="inline"/>
                        <span class="text-red-600 text-sm">*</span>
                        <x-library::input.text id="handle" wire:model.defer="handle" required/>
                        <x-library::input.error for="handle"/>
                    </div>
                </div>
                <x-slot:footer>
                    <x-jet-action-message class="mr-3 text-success-600" on="account_saved">
                        {{ \Trans::get('Saved.') }}
                    </x-jet-action-message>

                    <x-jet-button wire:click="updateAccount" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="updateAccount">{{ \Trans::get('Save') }}</span>
                        <span wire:loading wire:target="updateAccount">{{ \Trans::get('Saving...') }}</span>
                    </x-jet-button>
                </x-slot:footer> {{-- Additional Cards --}}
                <x-slot:additional>
                    <x-vertical-tabs.panel-section>
                        <x-slot:title>Password</x-slot:title>
                        <x-slot:description>{{ \Trans::get('Ensure your account is using a long, random password to stay secure.') }}</x-slot:description>
                        <div class="mt-6 grid grid-cols-4 gap-6">
                            <div class="col-span-4">
                                <x-jet-label for="current_password" value="{{ \Trans::get('Current Password') }}"/>
                                <x-jet-input id="current_password" type="password" class="mt-1 block w-full" wire:model.defer="state.current_password"
                                             autocomplete="current-password"/>
                                <x-jet-input-error for="current_password" class="mt-2"/>
                            </div>

                            <div class="col-span-4">
                                <x-jet-label for="password" value="{{ \Trans::get('New Password') }}"/>
                                <x-jet-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password" autocomplete="new-password"/>
                                <x-jet-input-error for="password" class="mt-2"/>
                            </div>

                            <div class="col-span-4">
                                <x-jet-label for="password_confirmation" value="{{ \Trans::get('Confirm Password') }}"/>
                                <x-jet-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="state.password_confirmation"
                                             autocomplete="new-password"/>
                                <x-jet-input-error for="password_confirmation" class="mt-2"/>
                            </div>
                        </div>
                        <x-slot:footer>
                            <x-jet-action-message class="mr-3 text-success-600" on="password_saved">
                                {{ \Trans::get('Saved.') }}
                            </x-jet-action-message>

                            <x-jet-button wire:click="updatePassword" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="updatePassword">{{ \Trans::get('Save') }}</span>
                                <span wire:loading wire:target="updatePassword">{{ \Trans::get('Saving...') }}</span>
                            </x-jet-button>
                        </x-slot:footer>
                    </x-vertical-tabs.panel-section>
                </x-slot:additional>
            </x-vertical-tabs.panel>
            <x-vertical-tabs.panel>
                <x-slot:title>{{ Trans::get('Notification Settings') }}</x-slot:title>
                <x-slot:description>{{ Trans::get('Change your notification settings.')}}</x-slot:description>

                <x-slot:footer>
                    <x-jet-action-message class="mr-3 text-success-600" on="account_saved">
                        {{ \Trans::get('Saved.') }}
                    </x-jet-action-message>
                    <livewire:notification-manager/>
                    <x-jet-button wire:click="updateAccount" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="updateAccount">{{ \Trans::get('Save') }}</span>
                        <span wire:loading wire:target="updateAccount">{{ \Trans::get('Saving...') }}</span>
                    </x-jet-button>
                </x-slot:footer>
            </x-vertical-tabs.panel>
        </x-slot:panels>
    </x-vertical-tabs>
@endsection
