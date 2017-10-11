let mix = require('laravel-mix').mix;

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

//mix.js('resources/assets/js/app.js', 'public/js')
   //.sass('resources/assets/sass/app.scss', 'public/css');
// mix.browserSync({
    // proxy: 'd3-app.dev'
// });

mix.combine([
    'public/css/bootstrap.min.css',
    'public/css/font-awesome.min.css',
    'public/css/style.css',
    'public/css/swiper.css',
    'public/css/dark.css',
    'public/css/font-icons.css',
    'public/css/animate.css',
    'public/css/magnific-popup.css',
    'public/css/responsive.css',
    'public/css/additional.css'
], 'public/css/d3all.css').version();

//mix.js('public/js/plugins.js','public/js/d3plugins.js').version();
//mix.js('public/js/functions.js','public/js/d3functions.js').version();
mix.browserSync({
    proxy:'d3-app.dev',
    // Open the site in Chrome & Firefox
    browser: ["google chrome", "firefox"],
    // Don't show any notifications in the browser.
    notify: false
});
