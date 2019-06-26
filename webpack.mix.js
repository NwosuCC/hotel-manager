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

// App js
mix.js('resources/js/app.js', 'public/js');

// App css
mix.sass('resources/sass/app.scss', 'public/css');


// General Mix options
// mix.options({
//   processCssUrls: false,
// });


// Environment Mix options
if (mix.inProduction()) {
  mix.version();
}

