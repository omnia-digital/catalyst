@props([
    'textColor' => 'text-heading-default-color',
    'textSize' => 'text-base',
    'boldClass' => 'font-medium',
    'class'=>''
])

<x-library::heading.heading heading="h4"
                            :text-color="$textColor"
                            :text-size="$textSize"
                            :bold-class="$boldClass"
                            :class="$class"
>{{ $slot }}</x-library::heading.heading>
