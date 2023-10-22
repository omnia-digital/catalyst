<aside class="sticky h-screen max-w-md overflow-y-scroll scrollbar-hide top-20 pb-24 {{ $class ?? '' }}">
    <div class="space-y-4">
        <livewire:catalyst::partials.trending-section type="{{ $type ?? '' }}"/>
        <livewire:catalyst::partials.who-to-follow-section/>

        @auth
            <livewire:catalyst::partials.applications/>
        @endauth
    </div>
    <div class="mt-4 text-center">
        &copy; {{ Date('Y') }} {{ config('app.name') }}. All Rights Reserved.
    </div>
</aside>
