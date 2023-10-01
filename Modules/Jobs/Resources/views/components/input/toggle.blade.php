<span
        x-data="{ on: @entangle($attributes->wire('model')).live }"
        x-on:click="on = !on"
        x-on:keydown.space.prevent="on = !on"
        x-bind:class="{ 'bg-gray-200': !on, 'bg-light-blue-600': on }"
        :aria-checked="on === null ? true : on.toString()"
        role="checkbox"
        tabindex="0"
        aria-checked="false"
    {{ $attributes->merge(['class' => 'relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:shadow-outline bg-gray-200']) }}
>
    <span x-bind:class="{ 'translate-x-5': on, 'translate-x-0': !on }"
          class="inline-block h-5 w-5 rounded-full bg-white shadow transform transition ease-in-out duration-200 translate-x-0"
          aria-hidden="true"></span>
</span>
