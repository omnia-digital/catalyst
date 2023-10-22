<aside class="sticky h-screen max-w-md overflow-y-scroll scrollbar-hide top-20 pb-24 {{ $class ?? '' }}">
    <div class="space-y-4">
        <livewire:catalyst-social::partials.trending-section type="{{ $type ?? '' }}"/>
        <livewire:catalyst-social::partials.who-to-follow-section/>

        @auth
            <livewire:catalyst-social::partials.applications/>
        @endauth
    </div>
    <div class="mt-4 text-center">
        &copy; {{ Date('Y') }} {{ config('app.name') }}. All Rights Reserved.
    </div>
</aside>
