@props([
'intent',
'stripeKey' => config('services.stripe.key'),
'event' => null,
'message' => null,
'confirmationText'
])

<div
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

            if (!this.stripe) {
                this.stripe = Stripe('{{ $stripeKey }}');

                this.cardElement = this.stripe.elements().create('card');

                this.cardElement.mount('#card_element');
            }

            const { setupIntent, error } = await this.stripe.confirmCardSetup(
                '{{ $intent->client_secret }}', {
                    payment_method: {
                        card: this.cardElement,
                        billing_details: {
                            name: this.cardHolderName,
{{--                            address: {--}}
{{--                                city: this.city,--}}
{{--                                country: this.country,--}}
{{--                                line1: this.line1,--}}
{{--                                zip: this.zip,--}}
{{--                                state: this.state--}}
{{--                            },--}}
                        }
                    }
                }
            );

            if (error) {
                this.errorMessage = error.message;
                this.loading = false;
            } else {
                const cardElement = this.cardElement;

                $wire.set('stripeToken', setupIntent.payment_method);
                $wire.updateStripePaymentMethod('{{ $event }}', '{{ $message }}')
                    .then(result => {
                        cardElement.clear();
                    });
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
        <x-library::input.label for="card_holder_name" value="Card Holder Name"/>
        <x-library::input.text x-model="cardHolderName" id="card_holder_name" placeholder="John Smith"/>
        <x-library::input.error for="card_holder_name"/>
    </div>

    <!-- Stripe Elements Placeholder -->
    <div class="mt-2 flex w-full rounded-md shadow-sm p-3 border border-gray-300 focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50">
        <div wire:ignore id="card_element" class="block w-full sm:text-sm sm:leading-5"></div>
    </div>

    <p x-show="errorMessage" x-text="errorMessage" class="text-right text-red-500 text-sm mt-2"></p>

    <div class="py-2 flex justify-end">
        <button
            x-on:click.prevent="confirmCard"
            x-bind:disabled="loading"
            x-bind:class="{'bg-gray-600 cursor-not-allowed': loading, 'bg-gray-800 hover:bg-gray-500 active:bg-gray-600': !loading}"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"
        >
            Save
        </button>
    </div>
</div>

@once
    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>
    @endpush
@endonce
