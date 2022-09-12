<section
        x-show="isCurrent($id('step-wizard', whichChild($el, $el.parentElement)))"
        x-bind:aria-labelledby="$id('step-wizard', whichChild($el, $el.parentElement))"
        {{ $attributes->merge(['class' => 'p-8']) }}
        style="display: none"
>
    {{ $slot }}
</section>
