@props([
    'textColor' => 'text-white-text-color',
    'textSize' => 'text-3xl sm:text-4xl lg:text-3xl',
    'boldClass' => 'font-medium',
    'class'=>''
])

<x-library::heading.heading heading="h1"
                            :text-color="$textColor"
                            :text-size="$textSize"
                            :bold-class="$boldClass"
                            :class="$class"
>{{ $slot }}</x-library::heading.heading>
