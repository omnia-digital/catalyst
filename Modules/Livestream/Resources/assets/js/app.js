require('./bootstrap');

// import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Clipboard from "@ryangjchandler/alpine-clipboard"
import trap from '@alpinejs/trap'

Alpine.plugin(Clipboard)
Alpine.plugin(trap)

// window.Alpine = Alpine
// window.Alpine.start()
Livewire.start();

window.Vapor = require('laravel-vapor');
