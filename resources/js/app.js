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
    resolve: (name) => {
        let parts = name.split('::')
        let type = false
        if (parts.length > 1) type = parts[0]
        if(type) {
            let nameVue = parts[1].split('.')[0]
            return require("../../Modules/" + parts[0] + "/Resources/assets/js/Pages/" + nameVue + ".vue").default
        }else {
            return require(`./Pages/${name}`).default
        }
    },
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            // .component("font-awesome-icon", FontAwesomeIcon)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
