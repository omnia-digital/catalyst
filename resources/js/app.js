import './bootstrap';
import 'tw-elements';

import {Alpine, Livewire} from '../../vendor/livewire/livewire/dist/livewire.esm';
import Clipboard from "@ryangjchandler/alpine-clipboard";
import Tooltip from "@ryangjchandler/alpine-tooltip";

Alpine.plugin(Tooltip);
Alpine.plugin(Clipboard);

Livewire.start();

// window.Vapor = require('laravel-vapor');

