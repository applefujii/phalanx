const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .css('resources/css/user-master/index.css', 'public/css/user-master')
    .css('resources/css/user-master/create_and_edit.css', 'public/css/user-master')
    .css('resources/css/notification/create_and_edit.css', 'public/css/notification');
