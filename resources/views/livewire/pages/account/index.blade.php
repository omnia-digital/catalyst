@extends('social::livewire.layouts.pages.account-page-layout')

@section('content')
    <x-vertical-tabs>
        <x-slot:items>
            <x-vertical-tabs.item icon="cog">Account</x-vertical-tabs.item>
            <x-vertical-tabs.item icon="user-circle">Profile</x-vertical-tabs.item>
            <x-vertical-tabs.item icon="key">Password</x-vertical-tabs.item>
            <x-vertical-tabs.item icon="bell">Notifications</x-vertical-tabs.item>
        </x-slot>

        <x-slot:panels>
            <x-vertical-tabs.panel>
                <x-slot:title>Account</x-slot>
                <x-slot:description>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed aut omnis officiis minus impedit et veritatis voluptatem quae a officia, totam velit, atque molestiae! Harum architecto nam ipsa quidem sit.</x-slot>
                <div class="mt-6 grid grid-cols-4 gap-6">
                <p>Stuff</p>
                <p>Stuff</p>
                <p>Stuff</p>
                </div>
                <x-slot:additional>
                    <x-vertical-tabs.panel-section>
                        <x-slot:title>More Account Stuff</x-slot>
                        <p>More Stuff</p>
                    </x-vertical-tabs.panel-section>
                </x-slot>
            </x-vertical-tabs.panel>

            <x-vertical-tabs.panel x-cloak>
                <x-slot:title>Profile</x-slot>
            </x-vertical-tabs.panel>

            <x-vertical-tabs.panel x-cloak>
                <x-slot:title>Password</x-slot>
            </x-vertical-tabs.panel>

            <x-vertical-tabs.panel x-cloak>
                <x-slot:title>Notifications</x-slot>
            </x-vertical-tabs.panel>
            
        </x-slot>
    </x-vertical-tabs>
@endsection
