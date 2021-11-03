require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

// Font Awesome
// import { library } from '@fortawesome/fontawesome-svg-core'
// import { faLink } from "@fortawesome/pro-light-svg-icons";
// import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
//
// library.add(faLink);

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'IndieGameDev';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            // .component("font-awesome-icon", FontAwesomeIcon)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
