@props([
    'content',
    'action'
])

<div {{ $attributes->merge(['class' => 'rounded-md bg-primary-light p-4']) }}>
    <div class="flex">
        <div class="flex-shrink-0">
            <!-- Heroicon name: solid/information-circle -->
            <svg class="h-5 w-5 text-secondary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="var(--text-light-text-color)" aria-hidden="true">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="ml-3 flex-1 md:flex md:justify-between">
            <p {{ $content->attributes->class(['text-sm text-secondary-dark']) }}>
                {{ $content }}
            </p>

            @if (isset($action))
                <p class="mt-3 text-sm md:mt-0 md:ml-6">
                    <a {{ $action->attributes->merge(['href' => '#', 'class' => 'whitespace-nowrap font-medium text-secondary-dark hover:text-secondary-dark']) }}>
                        {{ $action }}
                    </a>
                </p>
            @endif
        </div>
    </div>
</div>
