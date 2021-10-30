<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },
        props: ['href', 'active'],

        computed: {
            classes() {
                return this.active
                    ? 'inline-flex items-center px-1 pt-1 pb-1 border-b-2 border-primary text-lg font-bold leading-5 text-primary focus:outline-none focus:border-primary transition'
                    :
                    'inline-flex items-center px-1 pt-1 pb-1 border-b-2 border-transparent text-lg font-bold leading-5 text-gray-500 hover:text-gray-700 hover:border-primary focus:outline-none focus:text-gray-700 focus:border-gray-300 transition'
            }
        }
    })
</script>
