require('./bootstrap');

import Alpine from 'alpinejs'
import Clipboard from "@ryangjchandler/alpine-clipboard"
import trap from '@alpinejs/trap'
import focus from '@alpinejs/focus'

Alpine.plugin(Clipboard)
Alpine.plugin(trap)
Alpine.plugin(focus)

window.Alpine = Alpine
window.Alpine.start()

window.Vapor = require('laravel-vapor');
