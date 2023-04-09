<div class="mt-4">
    @if ($team->hasStripeConnectAccount())
        <div>
            <h3 class="text-lg font-medium leading-6 text-gray-900">Stats</h3>
            <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                    <dt class="truncate text-sm font-medium text-gray-500">Total Subscribers</dt>
                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ number_format($subscriptions->total()) }}</dd>
                </div>
            </dl>
        </div>

        <x-library::table class="mt-4">
            <x-slot:head>
                <x-tables::row>
                    <x-library::table.head>User</x-library::table.head>
                    <x-library::table.head>Plan</x-library::table.head>
                    <x-library::table.head>Date</x-library::table.head>
                </x-tables::row>
            </x-slot:head>
            <x-slot:body>
                @forelse ($subscriptions as $subscription)
                    <x-tables::row>
                        <x-library::table.cell>{{ $subscription->owner->name }}</x-library::table.cell>
                        <x-library::table.cell>{{ $plans->where('stripe_id', $subscription->stripe_price)->first()['name'] ?? '-' }}</x-library::table.cell>
                        <x-library::table.cell>{{ $subscription->created_at->format('Y-m-d') }}</x-library::table.cell>
                    </x-tables::row>
                @empty
                    <x-tables::row>
                        <x-library::table.cell colspan="3" class="text-center">No Subscriptions</x-library::table.cell>
                    </x-tables::row>
                @endforelse
            </x-slot:body>
        </x-library::table>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
            @if (!$team->hasStripeConnectAccount())
                <p>You don't have a Stripe Account. Please click the below button to create one!</p>

                <x-library::button wire:click.prevent="connectStripe" wire:target="connectStripe">
                    Create Stripe Account
                </x-library::button>
            @elseif (!$team->stripeConnectOnboardingCompleted())
                <x-library::button wire:click.prevent="connectStripe" wire:target="connectStripe">
                    Finish Onboarding Process
                </x-library::button>
            @endif
        </div>
    @endif
</div>
