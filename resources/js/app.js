require('./bootstrap');
import 'tw-elements';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Clipboard from "@ryangjchandler/alpine-clipboard";
import Tooltip from "@ryangjchandler/alpine-tooltip";
import trap from '@alpinejs/trap'

Alpine.plugin(Tooltip);
Alpine.plugin(Clipboard)
Alpine.plugin(trap)

Livewire.start()

window.Vapor = require('laravel-vapor');

