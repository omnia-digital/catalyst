require('./bootstrap');
import 'tw-elements';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';
import Clipboard from "@ryangjchandler/alpine-clipboard";
import FormsAlpinePlugin from '../../vendor/filament/forms/dist/module.esm'
import Tooltip from "@ryangjchandler/alpine-tooltip";
import Intersect from '@alpinejs/intersect'
import confetti from "canvas-confetti";

Alpine.plugin(FormsAlpinePlugin)
Alpine.plugin(focus)
Alpine.plugin(collapse)
Alpine.plugin(Clipboard)
Alpine.plugin(Tooltip);
Alpine.plugin(Intersect);

window.Alpine = Alpine;
window.Alpine.start()

Livewire.on('confetti', () => {
    var count = 200;
    var defaults = {
        origin: { y: 0.7 }
    };

    function fire(particleRatio, opts) {
        confetti(Object.assign({}, defaults, opts, {
            particleCount: Math.floor(count * particleRatio)
        }));
    }

    fire(0.25, {
        spread: 26,
        startVelocity: 55,
    });
    fire(0.2, {
        spread: 60,
    });
    fire(0.35, {
        spread: 100,
        decay: 0.91,
        scalar: 0.8
    });
    fire(0.1, {
        spread: 120,
        startVelocity: 25,
        decay: 0.92,
        scalar: 1.2
    });
    fire(0.1, {
        spread: 120,
        startVelocity: 45,
    });
})


