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
                'border-indigo-600 hover:border-indigo-800': isCompleted($el.id),
                'border-indigo-600': isCurrent($el.id),
                'border-gray-200 hover:border-gray-300': isUpcoming($el.id)
            }"
            x-bind:aria-current="isCurrent($el.parentElement.id) ? 'step' : ''"
            {{ $attributes->merge(['class' => 'pl-4 py-2 flex flex-col border-l-4 md:pl-0 md:pt-4 md:pb-0 md:border-l-0 md:border-t-4']) }}
    >
        <span
                x-bind:class="{
                    'text-indigo-600 group-hover:text-indigo-800': isCompleted($el.parentElement.id),
                    'text-indigo-600 ': isCurrent($el.parentElement.id),
                    'text-gray-500 group-hover:text-gray-700': isUpcoming($el.parentElement.id)
                }"
                class="text-xs font-semibold tracking-wide uppercase"
        >
            {{ $title }}
        </span>
        <span class="text-sm font-medium">{{ $description }}</span>
    </a>
</li>
