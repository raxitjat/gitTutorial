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
    .sass('resources/sass/app.scss', 'public/css');




mix.js('resources/js/admin/sb-admin-2.min.js','public/admin/js')
.sass('resources/sass/admin/sb-admin-2.scss', 'public/admin/css').options({
    processCssUrls: false
});

// mix.js('resources/sass/admin/sb-admin-2.scss', 'public/admin/css').options({
//     processCssUrls: false
// });
mix.combine([
    "resources/js/admin/demo/chart-area-demo.js",
    // "resources/js/admin/demo/chart-bar-demo.js",
    "resources/js/admin/demo/chart-pie-demo.js",
    "resources/js/admin/demo/datatables-demo.js",

],"public/admin/js/demo.js");
mix.combine([
    
    "resources/vendor/jquery/jquery.min.js",
    // "resources/vendor/jquery/jquery.slim.min.js",
    
    "resources/vendor/bootstrap/js/bootstrap.bundle.min.js",        
    // "resources/vendor/bootstrap/js/bootstrap.min.js",    

    "resources/vendor/jquery-easing/jquery.easing.min.js",
    
    "resources/vendor/chart.js/Chart.min.js",
    "resources/vendor/chart.js/Chart.bundle.min.js",

    "resources/vendor/datatables/jquery.dataTables.min.js",
    "resources/vendor/datatables/dataTables.bootstrap4.min.js",

    // "resources/vendor/fontawesome-free/js/fontawesome.min.js",
    // "resources/vendor/fontawesome-free/js/all.min.js",
    // "resources/vendor/fontawesome-free/js/brands.min.js",
    // "resources/vendor/fontawesome-free/js/conflict-detection.min.js",
    // "resources/vendor/fontawesome-free/js/regular.min.js",
    // "resources/vendor/fontawesome-free/js/solid.min.js",
    // "resources/vendor/fontawesome-free/js/v4-shims.min.js",

  ], "public/admin/js/vendor.js");

  mix.combine([
    "resources/vendor/bootstrap/scss/bootstrap.scss",      
    "resources/vendor/bootstrap/scss/bootstrap-reboot.scss",      
    "resources/vendor/bootstrap/scss/bootstrap-grid.scss",      
    // "resources/vendor/fontawesome-free/scss/fontawesome.scss", 
    "resources/vendor/fontawesome-free/css/all.min.css",     
  ], "public/admin/css/vendor.css");

  mix.copyDirectory("resources/vendor/fontawesome-free/webfonts", "public/admin/webfonts");
  mix.copyDirectory("resources/img", "public/admin/img");
