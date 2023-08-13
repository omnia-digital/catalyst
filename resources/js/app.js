require('./bootstrap');
import 'tw-elements';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Clipboard from "@ryangjchandler/alpine-clipboard";
import Tooltip from "@ryangjchandler/alpine-tooltip";

Alpine.plugin(Tooltip);
Alpine.plugin(Clipboard)

Livewire.start()



