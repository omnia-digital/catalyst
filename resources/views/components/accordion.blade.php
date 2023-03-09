<div class="space-y-4">
    <div class="accordion accordion-flush" id="accordion-{{ $title }}">
        <div class="accordion-item">
            <h2 class="accordion-header mb-0" id="flush-heading-{{ $title }}">
                <button class="accordion-button
                                        relative
                                        flex
                                        items-center
                                        w-full
                                        py-4
                                        px-5
                                        text-base text-gray-800 text-left
                                        border-0
                                        rounded-none
                                        transition
                                        focus:outline-none
                                      " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{ $title }}" aria-expanded="false"
                        aria-controls="flush-collapse-{{ $title }}">
                    <div>
                        <div class="flex items-center space-x-6">

                            <x-library::heading.2 class="text-heading-default-color uppercase tracking-wide font-semibold">{{ $title }}</x-library::heading.2>

                            @if($mainImageSrc)
                                @if($mainUrl)
                                    <a href="{{ $mainUrl }}" target="_blank">
                                        @endif
                                        <img src="{{ $mainImageSrc }}" class="h-12 rounded-full object-cover"/>
                                        @if($mainUrl)
                                    </a>
                                @endif
                            @endif

                            {{--                                <div class="inline-flex items-center text-md">--}}
                            {{--                                    <button type="button" class="inline-flex items-center px-4 py-2 rounded-full bg-primary text-white-text-color text-sm tracking-wide font-medium hover:opacity-75">--}}
                            {{--                                        <span>Follow</span>--}}
                            {{--                                    </button>--}}
                            {{--                                </div>--}}
                        </div>
                        <p>{{ $description }}</p>
                    </div>
                </button>
            </h2>
            <div id="flush-collapse-{{ $title }}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{ $title }}"
                 data-bs-parent="#accordion-{{ $title }}">
                <div class="accordion-body md:py-4 md:px-5">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
