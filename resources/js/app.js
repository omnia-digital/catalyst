require('intersection-observer');
IntersectionObserver.prototype.POLL_INTERVAL = 100;

require('./bootstrap');

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';

Alpine.plugin(focus)
Alpine.plugin(collapse)

window.Alpine = Alpine;

Alpine.start();



