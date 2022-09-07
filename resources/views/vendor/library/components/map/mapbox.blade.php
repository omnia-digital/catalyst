@props([
    'id' => uniqid(),
    'places' => [],
    'center' => [],
    'hideControls' => false,
    'zoom' => 2,
    'mapStyle' => 'mapbox://styles/mapbox/streets-v11', // More styles: https://www.mapbox.com/gallery/ + https://docs.mapbox.com/api/maps/styles/#mapbox-styles
])

<div wire:ignore id="{{ $id }}" {{ $attributes }}></div>

@php
    $places = $this->formatPlaces($places);

    $center = empty($center) ? ($places[0]['geometry']['coordinates'] ?? []) : $center;
@endphp

@once
    @push('scripts')
        <script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
        <link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet'/>

        <script>
            mapboxgl.accessToken = '{{ config('library.place.mapbox.api_key') }}';
            const map = new mapboxgl.Map({
                container: '{{ $id }}',
                style: '{{ $mapStyle }}',
                zoom: '{{ $zoom }}'
            });

            // Auto-detect location if browser supports
            if ('geolocation' in navigator) {
                navigator.geolocation.getCurrentPosition(position => {
                    map.center = [position.coords.longitude, position.coords.latitude];
                });
            } else {
                map.center = Array.from(@js($center));
            }

            const removePlaces = () => {
                map.removeLayer('places');
                map.removeSource('places');
            };

            const addPlaces = (places) => {
                map.addSource('places', {
                    // This GeoJSON contains features that include an "icon"
                    // property. The value of the "icon" property corresponds
                    // to an image in the Mapbox Streets style's sprite.
                    'type': 'geojson',
                    'data': {
                        'type': 'FeatureCollection',
                        'features': places
                    }
                });
                // Add a layer showing the places.
                map.addLayer({
                    'id': 'places',
                    'type': 'symbol',
                    'source': 'places',
                    'layout': {
                        'icon-image': '{icon}',
                        'icon-allow-overlap': true
                    }
                });
            };

            map.on('load', () => {
                addPlaces(Array.from(@js($places)));

                // When a click event occurs on a feature in the places layer, open a popup at the
                // location of the feature, with description HTML from its properties.
                map.on('click', 'places', (e) => {
                @this.showPlaceDetail(e.features[0].properties.id);

                    // Copy coordinates array.
                    const coordinates = e.features[0].geometry.coordinates.slice();
                    const description = e.features[0].properties.description;

                    // Ensure that if the map is zoomed out such that multiple
                    // copies of the feature are visible, the popup appears
                    // over the copy being pointed to.
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    new mapboxgl.Popup()
                        .setLngLat(coordinates)
                        .setHTML(description)
                        .addTo(map);
                });

                // Change the cursor to a pointer when the mouse is over the places layer.
                map.on('mouseenter', 'places', () => {
                    map.getCanvas().style.cursor = 'pointer';
                });

                // Change it back to a pointer when it leaves.
                map.on('mouseleave', 'places', () => {
                    map.getCanvas().style.cursor = '';
                });
            });

            @if ($hideControls === false)
            // Add zoom and rotation controls to the map.
            map.addControl(new mapboxgl.NavigationControl());
            @endif

            window.addEventListener('{{ $id }}', e => {
                const eventType = e.detail.type;

                if (eventType === 'loadPlaces') {
                    removePlaces();
                    addPlaces(e.detail.places)
                }

                if (eventType === 'fly') {
                    map.flyTo({
                        center: e.detail.coordinate,
                        essential: true // this animation is considered essential with respect to prefers-reduced-motion
                    });
                }
            });
        </script>
    @endpush
@endonce
