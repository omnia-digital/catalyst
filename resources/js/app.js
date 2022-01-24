import AppLayout from "./Layouts/AppLayout";

require('./bootstrap');

import { createApp, h } from 'vue';
import {createInertiaApp, Link} from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import AppLayout from "@/Layouts/AppLayout";
import JetNavLink from '@/Jetstream/NavLink.vue'
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'

// Font Awesome
// import { library } from '@fortawesome/fontawesome-svg-core'
// import { faLink } from "@fortawesome/pro-light-svg-icons";
// import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
//
// library.add(faLink);

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'IndieGameDev';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        let parts = name.split('::')
        let type = false
        if (parts.length > 1) type = parts[0]
        let page = {}
        if(type) {
            let nameVue = parts[1].split('.')[0]
            page = require("../../Modules/" + parts[0] + "/Resources/assets/js/Pages/" + nameVue + ".vue").default
        }else {
            page = require(`./Pages/${name}`).default
        }
        page.layout = page.layout || AppLayout

        return page
    },
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            // .component("font-awesome-icon", FontAwesomeIcon)
            .component("Link", Link)
            .component("JetNavLink", JetNavLink)
            .component("JetResponsiveNavLink", JetResponsiveNavLink)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({
    // The delay after which the progress bar will
    // appear during navigation, in milliseconds.
    delay: 250,

    // The color of the progress bar.
    color: '#29d',

    // Whether to include the default NProgress styles.
    includeCSS: true,

    // Whether the NProgress spinner will be shown.
    showSpinner: false,
})
