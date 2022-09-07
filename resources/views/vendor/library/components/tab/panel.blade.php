<section
    x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
    :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
    role="tabpanel"
    {{ $attributes->merge(['class' => 'p-8']) }}
>
    {{ $slot }}
</section>
