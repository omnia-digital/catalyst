<div>
    <div
            x-data="{
            open: true,

            initialSideMenu: null,

            showDetail: false,

            title: null,

            description: null,

            columns: [
                {id: 'email', label: 'Email Address', value: null},
                {id: 'ministry_name', label: 'Ministry Name', value: null},
                {id: 'birthday', label: 'Birthday', value: null},
                {id: 'facebook', label: 'Facebook', value: null},
                {id: 'whatsapp', label: 'Whatsapp', value: null},
                {id: 'marital_status', label: 'Marital Status', value: null},
                {id: 'ministry_website', label: 'Ministry Website', value: null},
                {id: 'ministry_affiliation', label: 'Ministry Affiliation', value: null},
                {id: 'ministry_training', label: 'Ministry Training', value: null},
                {id: 'profile_photo_url', label: 'Profile Photo Url', value: null},
                {id: 'lat', label: 'Latitude', value: null},
                {id: 'lng', label: 'Longitude', value: null},
                {id: 'city', label: 'City', value: null},
                {id: 'country', label: 'Country', value: null}
            ],

            populateData(data) {
                this.title = data.name;
                this.columns.forEach(column => {
                    column.value = data[column.id];
                });
            },

            resize() {
                {{-- let sideMenu = !this.initialSideMenu ? document.getElementById('side-menu').getBoundingClientRect() : this.initialSideMenu; --}}
                let body = document.querySelector('body').getBoundingClientRect();

                {{-- if (!this.initialSideMenu) {
                    this.initialSideMenu = sideMenu;
                } --}}

                {{-- document.getElementById('map').style.width = body.width - sideMenu.width + 'px'; --}}
            },

            selectContact(contact) {
                moveToMarker(contact.lat, contact.lng);
                openModal(contact);
            },

            reloadMarker(contacts) {
                removeAllMarkers();

                addMarkers(contacts);
            }
        }"
            x-init="function() {
            this.resize();

            $watch('open', value => {
                if (value === false) {
                    //document.getElementById('map').style.width = '100%';
                    map.setZoom(6);
                }
                else {
                    this.resize();
                    map.setZoom(4);
                }
            })
        }"
            x-on:refresh-map.window="reloadMarker($event.detail)"
            x-on:show-modal.window="showDetail = true; populateData($event.detail)"
            x-on:focus-to-country.window="focusToCountry($event.detail)"
            @keydown.window.escape="open = !open;" class="overflow-hidden relative bg-neutral"
    >
        <div class="h-12 text-sm bg-secondary flex items-center justify-between">
            <div class="px-4 flex items-center space-x-4">
                <button role="button" class="flex items-center"><span class="font-semibold mr-2">Sort:</span> By Date
                    <x-heroicon-o-arrow-sm-down class="w-4 h-4"/>
                </button>
                <button role="button" class="flex items-center">
                    <x-library::icons.icon name="fa-regular fa-filter" class="w-4 h-4"/>
                    <span class="ml-2 font-semibold">Filter (2)</span></button>
            </div>
            <div class="px-4 flex items-center space-x-4">
                <button role="button">
                    <x-heroicon-o-map class="w-6 h-6"/>
                </button>
                <button role="button">
                    <x-heroicon-o-calendar class="w-6 h-6"/>
                </button>
            </div>
        </div>
        <!-- Map -->
        <div wire:ignore id="map" class="w-full h-96"></div>

        <!-- Slide over -->
        {{-- <div class="absolute inset-0 overflow-hidden">
            <section class="absolute inset-y-0 right-0 pl-10 max-w-full flex sm:pl-16" aria-labelledby="slide-over-heading">
                <div
                    x-show="open"
                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    id="side-menu"
                    class="w-screen max-w-md"
                >
                    <div class="h-full flex flex-col bg-secondary shadow-xl overflow-y-scroll">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <x-heroicon-s-arrow-narrow-left x-on:click="showDetail = false" x-show="showDetail" class="w-5 h-5 cursor-pointer"/>
                                <x-library::heading.2 id="slide-over-heading" class="text-lg font-medium text-dark-text-color">
                                    Contacts
                                </x-library::heading.2>
                                <div class="ml-3 h-7 flex items-center">
                                    <button @click="open = false; setTimeout(() => open = true, 1000);" class="bg-secondary rounded-md text-light-text-color hover:text-base-text-color focus:ring-2 focus:ring-primary">
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Show All Contacts -->
                        <div x-show="!showDetail">
                            <div class="w-full max-w-xs mx-auto mb-5">
                                <div>
                                    <label for="country" class="block text-sm font-medium text-dark-text-color">Country</label>
                                    <select wire:model.live="filters.country" id="country" name="country" class="mt-1 block w-full pl-3 pr-10 py-2 text-base-text-color border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                                        <option selected>All</option>

                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }} {{ $country->flag }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="border-b border-neutral-light pb-2">
                                <div class="px-6">
                                    <nav class="-mb-px flex flex-wrap justify-center -mx-4">
                                        <a wire:click="selectCategory('All')" href="#"
                                           class="{{ 'All' === $selectedCategoryId ? 'border-primary text-primary whitespace-nowrap py-2 px-2 border-2 rounded-full font-medium text-sm' : 'border-transparent text-base-text-color hover:text-dark-text-color hover:border-gray-300 whitespace-nowrap py-2 px-2 border-2 rounded-full font-medium text-sm' }}" aria-current="page">
                                            All
                                        </a>

                                        @foreach ($categories as $category)
                                            @if ($category->id == $selectedCategoryId)
                                                <a wire:click="selectCategory('{{ $category->id }}')" href="#"
                                                   class="border-primary text-primary whitespace-nowrap py-2 px-2 border-2 rounded-full font-medium text-sm" aria-current="page">
                                                    {{ $category->name }}
                                                </a>
                                            @else
                                                <a wire:click="selectCategory('{{ $category->id }}')" href="#"
                                                   class="border-transparent text-base-text-color hover:text-dark-text-color hover:border-gray-300 whitespace-nowrap py-2 px-2 border-2 rounded-full font-medium text-sm">
                                                    {{ $category->name }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </nav>
                                </div>
                            </div>

                            <ul wire:loading.class="opacity-50" wire:target="selectCategory" class="divide-y divide-neutral-light overflow-y-auto">
                                @foreach ($contacts as $contact)
                                    <li class="px-6 py-5 relative">
                                        <div class="group flex justify-between items-center">
                                            <a
                                                x-on:click.prevent.stop="selectContact({{ $contact }})"
                                                href="#" class="-m-1 p-1 block"
                                            >
                                                <div class="absolute inset-0 group-hover:bg-gray-50" aria-hidden="true"></div>
                                                <div class="flex-1 flex items-center min-w-0 relative">
                                                    <div class="ml-4 truncate">
                                                        <p class="text-sm font-medium text-dark-text-color truncate">{{ $contact->name }}</p>
                                                        <p class="text-sm text-base-text-color truncate"><span></span>{{ $contact->ministry_name }}</p>
                                                        <p class="text-sm text-base-text-color truncate">
                                                            @if ($contact->city)
                                                                <span>{{ $contact->city }} </span>
                                                            @endif
                                                            @if ($contact->state)
                                                                <span>{{ $contact->state }}, </span>
                                                            @endif
                                                            @if ($contact->country)
                                                                <span>{{ Str::upper($contact->country) }} </span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Show Contact Detail -->
                        <div x-show="showDetail">
                            <div class="px-4 py-5 sm:px-6">
                                <x-library::heading.3 class="text-lg leading-6 font-medium text-dark-text-color" x-text="title"></x-library::heading.3>
                                <p class="mt-1 max-w-2xl text-sm text-base-text-color" x-text="description"></p>
                            </div>
                            <div class="border-t border-neutral-light px-4 py-5 sm:p-0">
                                <dl class="sm:divide-y sm:divide-neutral-light">
                                    <template x-for="column in columns" :key="column.id">
                                        <div x-show="column.value" class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-base-text-color" x-text="column.label"></dt>
                                            <dd class="mt-1 text-sm text-dark-text-color sm:mt-0 sm:col-span-2" x-text="column.value"></dd>
                                        </div>
                                    </template>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div> --}}
    </div>
</div>

@push('scripts')
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map.api_key') }}&callback=initMap&libraries=&v=weekly"
            defer></script>

    <script>
        let map;
        let geocoder;
        let markers = [];
        /* let contacts = {{-- $contacts->toJson() --}}; */

        let mapStyles = [
            {
                "featureType": "road",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            }
        ];

        function addMarkers(contacts) {
            contacts.forEach(contact => {
                let color = contact.contact_categories[0] ? contact.contact_categories[0].color : 'red';
                let url = "http://maps.google.com/mapfiles/ms/icons/";

                url += color + "-dot.png";

                let marker = new google.maps.Marker({
                    position: new google.maps.LatLng(contact.lat, contact.lng),
                    map,
                    title: contact.name,
                    icon: {
                        url: url
                    }
                });

                // Add click event for marker
                google.maps.event.addDomListener(marker, 'click', function () {
                    openModal(contact);
                });

                markers.push(marker);
            });
        }

        function openModal(contact) {
            let event = new CustomEvent('show-modal', {
                detail: contact,
                view: window,
                bubbles: true,
            });

            document.dispatchEvent(event);
        }

        function moveToMarker(lat, lng) {
            map.setCenter(new google.maps.LatLng(lat, lng));
            map.setZoom(6);
        }

        function removeAllMarkers() {
            markers.forEach(marker => marker.setMap(null));
        }

        function focusToCountry(country) {
            geocoder.geocode({"componentRestrictions": {"country": country}}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    map.fitBounds(results[0].geometry.viewport);
                }
            });
        }

        function initMap() {
            const defaultLatLng = {lat: 37.0902, lng: -95.7129};

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 4,
                center: defaultLatLng,
            });

            map.set('styles', mapStyles);

            geocoder = new google.maps.Geocoder();

            //addMarkers(contacts);
        }
    </script>
@endpush
