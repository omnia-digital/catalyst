<aside class="hidden xl:block sticky h-screen overflow-y-scroll scrollbar-hide top-20 pb-24 {{$class ?? ''}}">
    <div class="space-y-4">
        <livewire:social::partials.trending-section/>
        <livewire:social::partials.who-to-follow-section/>
        <livewire:social::partials.applications/>
    </div>
    <div class="text-center">
        &copy; {{ Date('Y') }} {{ config('app.name') }}. All Rights Reserved.
    </div>
</aside>
