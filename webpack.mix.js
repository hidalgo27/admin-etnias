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


mix.js('resources/js/app.js', 'public/js'),
mix.scripts(['resources/js/funciones.js',
            'node_modules/air-datepicker/dist/js/datepicker.min.js',
            'node_modules/air-datepicker/dist/js/i18n/datepicker.en.js'
], 'public/js/funciones.js')
// mix.scripts('resources/js/funciones.js', 'public/js/funciones.js')
   .sass('resources/sass/app.scss', 'public/css');