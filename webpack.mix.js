let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |.js('resources/assets/js/app.js', 'public/js')
 */
mix.js('resources/assets/js/app.js', 'public/js')
    .scripts('resources/assets/js/jquery.min.js', 'public/js/jquery.min.js')
    .scripts('resources/assets/js/jquery.form.js', 'public/js/jquery.form.js')
    .scripts('resources/assets/js/jquery.pjax.min.js', 'public/js/jquery.pjax.min.js')
    .mix.copyDirectory('resources/assets/img', 'public/img')
    .mix.copyDirectory('resources/assets/themes', 'public/themes')
    .mix.copyDirectory('resources/assets/plugins', 'public/plugins')
;
mix.styles([
    'resources/assets/css/merchant.css',
    'resources/assets/css/merchant.fixed.css'
], 'public/css/merchant.all.css').version();
mix.scripts([
    'resources/assets/js/common.js',
    'resources/assets/js/admin.js'
], 'public/js/admin.all.js').version();
mix.scripts([
    'resources/assets/js/common.js',
    'resources/assets/js/merchant.js'
], 'public/js/merchant.all.js').version();
mix.scripts([
    //'resources/assets/js/common.js',
    'resources/assets/js/member.js'
], 'public/js/member.all.js').version();
mix.styles([
    'resources/assets/css/member.css',
    'resources/assets/css/member.fixed.css'
], 'public/css/app.css').version();