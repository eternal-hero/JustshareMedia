const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

/*
mix.js('resources/js/app.js', 'public/js')
    .sourceMaps().copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]).copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts');
*/

mix.js("resources/js/app.js", "public/js/app.js")
    .sass("resources/sass/app.scss", "public/css/app.css")
    .sourceMaps().copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts');

if (mix.inProduction()) {
    mix.version();
}

mix.copyDirectory('vendor/tinymce/tinymce/icons', 'public/assets/tinymce/icons');
mix.copyDirectory('vendor/tinymce/tinymce/plugins', 'public/assets/tinymce/plugins');
mix.copyDirectory('vendor/tinymce/tinymce/skins', 'public/assets/tinymce/skins');
mix.copyDirectory('vendor/tinymce/tinymce/themes', 'public/assets/tinymce/themes');
mix.copy('vendor/tinymce/tinymce/jquery.tinymce.js', 'public/assets/tinymce/jquery.tinymce.js');
mix.copy('vendor/tinymce/tinymce/jquery.tinymce.min.js', 'public/assets/tinymce/jquery.tinymce.min.js');
mix.copy('vendor/tinymce/tinymce/tinymce.js', 'public/assets/tinymce/tinymce.js');
mix.copy('vendor/tinymce/tinymce/tinymce.min.js', 'public/assets/tinymce/tinymce.min.js');

mix.copyDirectory('node_modules/bootstrap-colorpicker/dist/css/', 'public/assets/bootstrap-colorpicker/css');
mix.copyDirectory('node_modules/bootstrap-colorpicker/dist/js/', 'public/assets/bootstrap-colorpicker/js');
