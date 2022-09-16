@props([
'position' => 'right',
'dropdownClasses' => ''
])

@php
    switch ($position) {
        case 'left':
            $positionClasses = 'origin-top-left left-0';
            break;
        case 'top':
            $positionClasses = 'origin-top';
            break;
        case 'none':
        case 'false':
            $positionClasses = '';
            break;
        case 'right':
        default:
            $positionClasses = 'origin-top-right right-0';
            break;
    }
@endphp

<div {{ $attributes->merge(['class' => 'flex justify-center']) }}>
    <div
            x-data="{
            open: false,
            toggle() {
                if (this.open) {
                    return this.close()
                }

                this.open = true
            },
            close(focusAfter) {
                this.open = false

                focusAfter && focusAfter.focus()
            }
        }"
            x-on:keydown.escape.prevent.stop="close($refs.trigger)"
            x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
            x-id="['dropdown']"
            class="relative"
    >
        <!-- Button -->
        <div
                x-ref="trigger"
                x-on:click="toggle()"
                :aria-expanded="open"
                :aria-controls="$id('dropdown')"
                {{ $trigger->attributes }}
        >
            {{ $trigger }}
        </div>

        <!-- Panel -->
        <div
                x-ref="panel"
                x-show="open"
                x-transition.origin.top.left
                x-on:click.outside="close($refs.trigger)"
                :id="$id('dropdown')"
                class="absolute {{ $positionClasses }} mt-2 w-36 bg-neutral border border-black rounded shadow-md overflow-hidden divide-y divide-black {{ $dropdownClasses }}"
                style="display: none;"
        >
            {{ $slot }}
        </div>
    </div>
</div>
