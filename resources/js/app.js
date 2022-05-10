require('./bootstrap');

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';
import Clipboard from "@ryangjchandler/alpine-clipboard"

Alpine.plugin(focus)
Alpine.plugin(collapse)
Alpine.plugin(Clipboard)

window.Alpine = Alpine;

Alpine.start();



