const mix = require('laravel-mix');
const tailwind = require('tailwindcss');

/* This is for the embed player script and CSS.
 * Run: npm run omnia-script to compile it
*/
mix.js("resources/js/scripts.js", "public/js/scripts.js")
    .js("resources/js/playlist.js", "public/js/playlist.js")
    .postCss("resources/css/embed.css", "public/css/embed.css", {}, [
        tailwind("./tailwind-embed-player.config.js")
    ])
    .postCss("resources/css/playlist.css", "public/css/playlist.css", {}, [
        tailwind("./tailwind-embed-playlist.config.js")
    ]);
