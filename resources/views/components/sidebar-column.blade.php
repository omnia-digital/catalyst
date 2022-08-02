<aside class="sticky h-screen max-w-sm overflow-y-scroll scrollbar-hide top-20 pb-24 {{$class ?? ''}}">
    <div class="space-y-4">
        <livewire:social::partials.trending-section type="{{$type ?? ''}}"/>
        <livewire:social::partials.who-to-follow-section/>
        <livewire:social::partials.applications/>
    </div>
    <div class="mt-4 text-center">
        &copy; {{ Date('Y') }} {{ config('app.name') }}. All Rights Reserved.
    </div>
</aside>
