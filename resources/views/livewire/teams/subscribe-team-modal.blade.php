<div>
    <x-library::modal id="subscribe-team" maxWidth="4xl">
        <x-slot:title>
            Subscribe Team: {{ $team->name }}
        </x-slot:title>
        <x-slot:content>
            <div class="mb-4">
                @if (!$this->billable->hasDefaultPaymentMethod())
                    <x-library::alert.warning>You don't have a default payment method. Please add one <a href="{{ route('social.billing') }}" class="font-medium hover:underline">here</a>.</x-library::alert.warning>
                @endif
            </div>
            <div>
                <fieldset>
                    <legend class="text-base font-medium text-gray-900">Select a plan</legend>

                    <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4">
                        @foreach ($teamPlans as $teamPlan)
                            <x-library::input.radio-card :title="$teamPlan['name']" wire:model="plan" wire:key="team-plan-{{ $teamPlan['stripe_id'] }}" :value="$teamPlan['stripe_id']">
                                <x-slot name="description" class="space-y-1">
                                    @foreach($teamPlan['features'] as $feature)
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
        </x-slot:content>
        <x-slot:actions>
            <x-library::button wire:click.prevent="subscribeTeam" wire:target="subscribeTeam">
                Subscribe
            </x-library::button>
        </x-slot:actions>
    </x-library::modal>
</div>
