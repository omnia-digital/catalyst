const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Articles/assets/js/app.js', 'js/articles.js')
    .sass( __dirname + '/Articles/assets/sass/app.scss', 'css/articles.css');

if (mix.inProduction()) {
    mix.version();
}
