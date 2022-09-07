@props([
    'places' => []
])

<!-- Map -->
<div wire:ignore id="map" {{ $attributes }}></div>

@once
    @push('scripts')
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('library.place.google.api_key') }}&callback=initMap&libraries=&v=weekly" defer></script>

        <script>
            let map;
            let geocoder;
            let markers = [];
            let places = Array.from({{ \Illuminate\Support\Js::from($places) }});
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

            function addMarkers(places) {
                places.forEach(place => {
                    let color = 'red';
                    let url = "http://maps.google.com/mapfiles/ms/icons/";
                    url += color + "-dot.png";
                    let marker = new google.maps.Marker({
                        position: new google.maps.LatLng(place.lat, place.lng),
                        map,
                        title: place.name,
                        icon: {
                            url: url
                        }
                    });
                    // Add click event for marker
                    google.maps.event.addDomListener(marker, 'click', function () {
                        openModal(place);
                    });
                    markers.push(marker);
                });
            }

            function openModal(place) {
                let event = new CustomEvent('show-modal', {
                    detail: place,
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
                addMarkers(places);
            }
        </script>
    @endpush
@endonce
