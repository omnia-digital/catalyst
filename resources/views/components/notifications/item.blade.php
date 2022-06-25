@props([
    'id',
    'icon' => 'heroicon-o-information-circle',
    'level' => 'info',
    'title',
    'subtitle' => null,
    'image' => null,
    'actionText' => 'View',
    'actionLink' => null,
    'isRead' => false
])

@php
    $iconColor = match ($level) {
        'success' => 'text-green-500',
        'danger' => 'text-red-500',
        'warning' => 'text-yellow-500',
        default => 'text-blue-500'
    };
@endphp

<li
        x-data="{
            isRead: '{{ $isRead }}',
            markAsRead() {
                if (this.isRead) {
                    return;
                }

                this.$wire.emitSelf('notificationRead', '{{ $id }}')
            }
        }"
        x-on:mouseenter.once="markAsRead"
        {{ $attributes->class(['py-4'])->merge() }}
>
    <div class="flex items-center space-x-4">
        <div class="flex-shrink-0">
            <x-dynamic-component :component="$icon" class="h-8 w-8 {{ $iconColor }}"/>
        </div>
        <div class="flex-1 min-w-0">
            @if ($image)
                <img src="{{ $image }}" class="rounded-full w-8 h-8 bg-gray-300 mb-2" alt="{{ $title }}"/>
            @endif

            <p @class([
                'text-sm text-gray-900 truncate',
                'font-bold' => !$isRead,
                'font-medium' => $isRead
            ])>
                {{ $title }}
            </p>

            @if ($subtitle)
                <p class="text-sm text-gray-500 truncate">
                    {{ $subtitle }}
                </p>
            @endif
        </div>

        @if ($actionLink)
            <div>
                <a href="{{ $actionLink }}" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                    {{ $actionText }}
                </a>
            </div>
        @endif
    </div>
</li>