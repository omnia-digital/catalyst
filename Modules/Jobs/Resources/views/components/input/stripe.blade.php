@props([
'intent',
'stripeKey' => config('services.stripe.key'),
])

<div
        wire:ignore
        x-data="{
        stripe: null,

        cardElement: null,

        errorMessage: '',

        cardHolderName: '',

        loading: false,

        confirmCard: async function() {
            this.errorMessage = '';

            this.loading = true;

            if (!this.cardHolderName) {
                this.errorMessage = 'The Card Holder Name field is required!';

                this.loading = false;

                return;
            }

            const { setupIntent, error } = await this.stripe.confirmCardSetup(
                '{{ $intent->client_secret }}', {
                    payment_method: {
                        card: this.cardElement,
                        billing_details: {
                            name: this.cardHolderName,
                            address: {
                                city: this.city,
                                country: this.country,
                                line1: this.line1,
                                postal_code: this.postal_code,
                                state: this.state
                            },
                        }
                    }
                }
            );

            if (error) {
                this.errorMessage = error.message;
                this.loading = false;
            } else {
                @this.set('stripeToken', setupIntent.payment_method);
                @this.call('updatePaymentMethod');
            }
        }
    }"
        x-init="function() {
        this.stripe = Stripe('{{ $stripeKey }}');

        this.cardElement = this.stripe.elements().create('card');

        this.cardElement.mount('#card_element');
    }"
        {{ $attributes }}
>
    <div>
        <x-input.label for="card_holder_name" value="Card Holder Name"/>
        <x-input.text x-model="cardHolderName" id="card_holder_name" placeholder="John Smith"/>
        <x-input.error for="card_holder_name"/>
    </div>

    <!-- Stripe Elements Placeholder -->
    <div wire:ignore class="mt-2 relative rounded-md shadow-sm">
        <div id="card_element" class="form-input block w-full sm:text-sm sm:leading-5"></div>
    </div>
    <p x-show="errorMessage" x-text="errorMessage" class="text-red-500 text-sm mt-2"></p>

    <div class="py-2 flex justify-end">
        <x-form.button
                x-on:click.prevent="confirmCard"
                x-bind:disabled="loading"
                x-bind:class="{'bg-gray-600 cursor-not-allowed': loading}"
        >
            Save
        </x-form.button>
    </div>
</div>

@once
    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>
    @endpush
@endonce
