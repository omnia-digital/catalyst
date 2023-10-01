<div>
    <x-library::heading.3>Payment Method</x-library::heading.3>

    @if (!$this->stripeBillable()->hasDefaultPaymentMethod())
        <x-library::alert.warning class="shadow my-4">Please add a default payment method.</x-library::alert.warning>
    @endif

    <div
            x-data="{
                editMode: '{{ !$this->stripeBillable()->hasDefaultPaymentMethod() }}'
            }"
            x-on:stripe-payment-method-updated.window="editMode = false"
            class="bg-white shadow sm:rounded-lg mt-4"
    >
        <div class="px-4 py-5 sm:p-6">
            <div x-show="editMode" style="display: none">
                <x-library::input.stripe :intent="$intent"/>
            </div>

            @if ($this->stripeBillable()->hasDefaultPaymentMethod())
                <div
                        x-show="!editMode"
                        class="rounded-md bg-gray-50 px-6 py-5 sm:flex sm:items-start sm:justify-between"
                        style="display: none"
                >
                    <h4 class="sr-only">Visa</h4>
                    <div class="sm:flex sm:items-start">
                        <svg class="h-8 w-auto sm:flex-shrink-0 sm:h-6" viewBox="0 0 36 24" aria-hidden="true">
                            <rect width="36" height="24" fill="#224DBA" rx="4"/>
                            <path fill="#fff"
                                  d="M10.925 15.673H8.874l-1.538-6c-.073-.276-.228-.52-.456-.635A6.575 6.575 0 005 8.403v-.231h3.304c.456 0 .798.347.855.75l.798 4.328 2.05-5.078h1.994l-3.076 7.5zm4.216 0h-1.937L14.8 8.172h1.937l-1.595 7.5zm4.101-5.422c.057-.404.399-.635.798-.635a3.54 3.54 0 011.88.346l.342-1.615A4.808 4.808 0 0020.496 8c-1.88 0-3.248 1.039-3.248 2.481 0 1.097.969 1.673 1.653 2.02.74.346 1.025.577.968.923 0 .519-.57.75-1.139.75a4.795 4.795 0 01-1.994-.462l-.342 1.616a5.48 5.48 0 002.108.404c2.108.057 3.418-.981 3.418-2.539 0-1.962-2.678-2.077-2.678-2.942zm9.457 5.422L27.16 8.172h-1.652a.858.858 0 00-.798.577l-2.848 6.924h1.994l.398-1.096h2.45l.228 1.096h1.766zm-2.905-5.482l.57 2.827h-1.596l1.026-2.827z"/>
                        </svg>
                        <div class="mt-3 sm:mt-0 sm:ml-4">
                            <div class="text-sm font-medium text-gray-900">
                                Ending with {{ $this->stripeBillable()->pm_last_four }}.
                            </div>
                            <div class="mt-1 text-sm text-gray-600 sm:flex sm:items-center">
                                <div class="mt-1 sm:mt-0">
                                    You can update your payment method at anytime.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-6 sm:flex-shrink-0">
                        <x-button x-on:click="editMode = true">Edit</x-button>
                    </div>
                </div>
            @endif

            @if ($this->stripeBillable()->hasDefaultPaymentmethod())
                <div x-show="editMode" class="flex items-center text-gray-700 mt-4" style="display: none">
                    <x-heroicon-o-arrow-left class="w-5 h-5 mr-2"/>
                    <a x-on:click.prevent="editMode = false" href="#" class="underline">Nevermind, I will keep my
                        current payment method.</a>
                </div>
            @endif
        </div>
    </div>
</div>
