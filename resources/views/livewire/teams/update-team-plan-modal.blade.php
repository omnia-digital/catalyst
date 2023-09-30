<div>
    @if ($this->currentPlan)
        <x-library::modal id="update-team-plan" maxWidth="4xl">
            <x-slot:title>
                Update Plan: {{ $team->name }}
            </x-slot:title>
            <x-slot:content>
                @if (!$this->currentPlan->onGracePeriod())
                    <div class="mb-4">
                        @if (!$this->billable->hasDefaultPaymentMethod())
                            <x-library::alert.warning>You don't have a default payment method. Please add one <a
                                        href="{{ route('billing.stripe-billing') }}"
                                        class="font-medium hover:underline">here</a>.
                            </x-library::alert.warning>
                        @endif
                    </div>
                    <div>
                        <fieldset>
                            <legend class="text-base font-medium text-gray-900">Select a plan</legend>

                            <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4">
                                @foreach ($teamPlans as $teamPlan)
                                    <x-library::input.radio-card :title="$teamPlan['name']" wire:model.live="plan"
                                                                 wire:key="team-plan-{{ $teamPlan['stripe_id'] }}"
                                                                 :value="$teamPlan['stripe_id']">
                                        <x-slot name="description" class="space-y-1">
                                            @foreach ($teamPlan['features'] as $feature)
                                                <div class="flex items-center space-x-2">
                                                    <x-heroicon-s-check-circle class="text-green-500 w-4 h-4"/>
                                                    <p>{{ $feature }}.</p>
                                                </div>
                                            @endforeach
                                        </x-slot>
                                    </x-library::input.radio-card>
                                @endforeach
                            </div>
                        </fieldset>
                        <x-library::input.error for="plan" class="mt-1"/>
                    </div>
                    <div class="mt-4">
                        <p>Or <a href="#" x-data x-on:click.prevent="$openModal('cancel-subscription')"
                                 class="text-danger-500 hover:text-danger-800">cancel your plan</a>.</p>
                    </div>
                @else
                    <p>
                        <span>Your subscription will be ended on {{ $this->currentPlan->ends_at->format('F jS, Y') }}.</span>
                        <a href="#" wire:click.prevent="resumeSubscription"
                           class="text-success-600 hover:text-success-800">Resume your subscription</a>?
                    </p>
                @endif
            </x-slot:content>
            <x-slot:actions>
                <x-library::button wire:click.prevent="updatePlan" wire:target="updatePlan">
                    Update Plan
                </x-library::button>
            </x-slot:actions>
        </x-library::modal>

        <x-library::confirm id="cancel-subscription" submit="cancelSubscription">
            <x-slot:title>Cancel Subscriptions</x-slot:title>
            <x-slot:content>
                Are you sure to cancel your subscription?
            </x-slot:content>
        </x-library::confirm>
    @endif
</div>
