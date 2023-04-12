<div class="bg-gray-50 overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-base leading-6 font-medium text-gray-900">
            Available Shortcodes
        </h3>
    </div>
    <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
        <dl class="sm:divide-y sm:divide-gray-200">
            @foreach (config('omnia.episode_template_shortcodes', []) as $shortcode)
                @php $shortcode = new $shortcode @endphp

                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt
                        x-data="{
                            isCopied: false,

                            copy() {
                                $clipboard('[{{ $shortcode->shortcode() }}]');

                                this.isCopied = true;

                                setTimeout(() => { this.isCopied = false }, 2000);
                            }
                        }"
                        class="text-sm font-medium text-gray-500 flex items-center"
                    >
                        <span>[{{ $shortcode->shortcode() }}]</span>
                        <div>
                            <x-heroicon-o-clipboard
                                x-on:click="copy"
                                x-show="!isCopied"
                                class="w-5 h-5 ml-1 cursor-pointer"/>

                            <x-heroicon-o-check
                                x-show="isCopied"
                                class="w-5 h-5 ml-1 text-green-500"/>
                        </div>
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $shortcode->replace() }}
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>
</div>
