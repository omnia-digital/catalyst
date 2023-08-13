require('./bootstrap');
import 'tw-elements';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';
import Clipboard from "@ryangjchandler/alpine-clipboard";
import Tooltip from "@ryangjchandler/alpine-tooltip";
import Intersect from '@alpinejs/intersect'

Alpine.plugin(focus)
Alpine.plugin(collapse)
Alpine.plugin(Clipboard)
Alpine.plugin(Tooltip);
Alpine.plugin(Intersect);

window.Alpine = Alpine;
window.Alpine.start()



