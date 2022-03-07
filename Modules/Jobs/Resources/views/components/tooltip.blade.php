@props([
    'trigger'
])

<div
    x-data
    x-init="function() {
        tippy('#{{ $trigger }}', {
            content: '{{ $slot }}',
{{--            animation: 'scale',--}}
        });
    }"
    {{ $attributes }}
>
</div>

@once
    @push('scripts')
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="https://unpkg.com/tippy.js@6"></script>
    @endpush
@endonce
