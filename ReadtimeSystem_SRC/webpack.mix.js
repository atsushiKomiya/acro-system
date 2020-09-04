const mix = require('laravel-mix');

mix.sourceMaps().js('node_modules/popper.js/dist/popper.js', 'public/js').sourceMaps();

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
   .js('resources/js/validation.js', 'public/js')
   .js('resources/js/leadtime.js', 'public/js')
   .js('resources/js/fileDownloader.js', 'public/js')
   .sass('resources/sass/child.scss', 'public/css')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/C_L01.scss', 'public/css')
   .sass('resources/sass/C_L11.scss', 'public/css')
   .sass('resources/sass/C_L10.scss', 'public/css')
   .sass('resources/sass/C_L21.scss', 'public/css')
   .sass('resources/sass/C_L20.scss', 'public/css')
   .sass('resources/sass/C_L31.scss', 'public/css')
   .sass('resources/sass/C_L30.scss', 'public/css')
   .sass('resources/sass/C_L50.scss', 'public/css')
   .sass('resources/sass/C_L51.scss', 'public/css')
   .sass('resources/sass/C_L52.scss', 'public/css')
   .sass('resources/sass/C_L53.scss', 'public/css')
   .sass('resources/sass/C_L54.scss', 'public/css')
   .sass('resources/sass/C_L55.scss', 'public/css')
   .sass('resources/sass/C_L56.scss', 'public/css')
   .sass('resources/sass/C_L57.scss', 'public/css')
   ;
