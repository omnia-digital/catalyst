@props([
    'title',
    'description' => null
])

<li class="md:flex-1">
    <a
            href="#"
            x-on:click.prevent="goToStep($el.id)"
            x-bind:id="$id('step-wizard', whichChild($el.parentElement, $refs.steplist))"
            x-bind:class="{
                'border-secondary hover:border-secondary-dark': isCompleted($el.id),
                'border-secondary': isCurrent($el.id),
                'border-gray-200 hover:border-gray-300': isUpcoming($el.id)
            }"
            x-bind:aria-current="isCurrent($el.parentElement.id) ? 'step' : ''"
            {{ $attributes->merge(['class' => 'pl-4 py-2 flex flex-col border-l-4 md:pl-0 md:pt-4 md:pb-0 md:border-l-0 md:border-t-4']) }}
    >
        <span
                x-bind:class="{
                    'text-secondary group-hover:text-secondary-dark': isCompleted($el.parentElement.id),
                    'text-secondary ': isCurrent($el.parentElement.id),
                    'text-base-text-color group-hover:text-dark-text-color': isUpcoming($el.parentElement.id)
                }"
                class="text-xs font-semibold tracking-wide uppercase"
        >
            {{ $title }}
        </span>
        <span class="text-sm font-medium">{{ $description }}</span>
    </a>
</li>
