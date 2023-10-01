@props(['submit'])

<section>
    <form wire:submit.prevent="{{ $submit }}">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div {{ $attributes->merge(['class' => 'bg-white py-6 px-4 space-y-6 sm:p-6']) }}>
                <div>
                    @if (isset($title))
                        <h2 id="payment_details_heading" class="text-lg leading-6 font-medium text-gray-900">
                            {{ $title }}
                        </h2>
                    @endif
                    @if (isset($description))
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            {{ $description }}
                        </p>
                    @endif
                </div>

                <div class="grid grid-cols-4 gap-6">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <span class="inline-flex rounded-md shadow-sm">
                        {{ $actions }}
                    </span>
                </div>
            @endif
        </div>
    </form>
</section>
