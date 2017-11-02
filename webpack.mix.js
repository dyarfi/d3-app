let mix = require('laravel-mix').mix;

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management @ https://laravel.com/docs/5.4/mix
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
],  'public/css/d3all.css').version();

mix.combine([
    'public/themes/ace-admin/css/bootstrap.min.css',
    'public/themes/ace-admin/css/ace.min.css',
    'public/themes/ace-admin/css/default.css'
],  'public/themes/ace-admin/css/d3all.css').options({
     processCssUrls: false
}).version();

mix.scripts([
    'public/js/plugins.js',
    'public/js/functions.js'
],  'public/js/d3all.js').version();

mix.scripts([
    'public/themes/ace-admin/js/bootstrap.min.js',
    'public/themes/ace-admin/js/bootbox.min.js',
    'public/themes/ace-admin/js/jquery-ui.custom.min.js',
    'public/themes/ace-admin/js/jquery.ui.touch-punch.min.js',
    'public/themes/ace-admin/js/ace-elements.min.js',
    'public/themes/ace-admin/js/ace.min.js'
],  'public/themes/ace-admin/js/d3all.js').version();

//mix.js('public/js/plugins.js','public/js/d3plugins.js').version();
//mix.js('public/js/functions.js','public/js/d3functions.js').version();

mix.browserSync({
    proxy:'autowapps.dev',
    // Open the site in Chrome & Firefox
    browser: ["google chrome", "firefox"],
    // Don't show any notifications in the browser.
    notify: false
});
