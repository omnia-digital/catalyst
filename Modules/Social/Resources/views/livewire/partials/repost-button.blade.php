<div class="inline-flex items-center text-sm">
    <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
        <x-heroicon-o-refresh :class="$show ? 'h-6 w-6' : 'h-5 w-5'" aria-hidden="true"/>
        <span class="font-medium text-gray-900">{{ $model->reposts ?? '' }}</span>
        <span class="sr-only">repost</span>
    </button>
</div>
