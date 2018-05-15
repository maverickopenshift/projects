let mix = require('laravel-mix');

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
    //mix.js('resources/assets/js/app.js', 'public/js');
    mix.copyDirectory('node_modules/summernote/dist/font','public/fonts')
        .copyDirectory('node_modules/font-awesome/fonts','public/fonts')
        .copyDirectory('node_modules/ionicons/dist/fonts','public/fonts')
        .copyDirectory('node_modules/admin-lte/bootstrap/fonts','public/fonts')
        .copyDirectory('resources/assets/js/ckeditor','public/js/ckeditor')
        .copyDirectory('node_modules/jstree','public/js/jstree')
        .copyDirectory('node_modules/highcharts','public/js/highcharts')
        .copyDirectory('node_modules/pdfjs-dist','public/js/pdfjs-dist')
        .copy('node_modules/admin-lte/plugins/iCheck/square/blue.png','public/css/blue.png')
        .copy('node_modules/admin-lte/plugins/iCheck/square/blue@2x.png','public/css/blue@2x.png')
        .copy('resources/assets/images','public/images')
        .copy('resources/assets/fonts','public/fonts')
        //.sass('app.scss')
        .styles([
            'public/css/app.css',
            'node_modules/admin-lte/bootstrap/css/bootstrap.css',
            'node_modules/datatables.net-bs/css/dataTables.bootstrap.css',
            'node_modules/datatables.net-buttons-bs/css/buttons.bootstrap.css',
            'resources/assets/css/bootstrap-tagsinput.css',
            'node_modules/datatables.net-fixedcolumns-bs/css/fixedColumns.bootstrap.css',
            'node_modules/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.css',
            'node_modules/datatables.net-responsive-bs/css/responsive.bootstrap.css',
            'node_modules/bootstrap/dist/sweetalert.css',
            'node_modules/sweetalert2/dist/sweetalert2.min.css',
            'node_modules/font-awesome/css/font-awesome.css',
            'node_modules/ionicons/dist/css/ionicons.css',
            'node_modules/admin-lte/plugins/datepicker/datepicker3.css',
            'resources/assets/js/bootstrap-switch/css/bootstrap3/bootstrap-switch.css',
            'node_modules/admin-lte/plugins/daterangepicker/daterangepicker.css',
            'node_modules/summernote/dist/summernote.css',
            'node_modules/admin-lte/plugins/iCheck/square/blue.css',
            'node_modules/admin-lte/plugins/select2/select2.css',
            'node_modules/admin-lte/dist/css/AdminLTE.css',
            'node_modules/admin-lte/dist/css/skins/skin-red-light.css',
            'node_modules/admin-lte/dist/css/skins/skin-red-light.css',
            // 'resources/assets/fonts/Oswald-SemiBold/styles.css',
            'resources/assets/css/fonts.css',
            'resources/assets/css/custom.css'
        ], 'public/css/all.css', './')
        .styles([
            'public/css/app.css',
            'node_modules/admin-lte/bootstrap/css/bootstrap.css',
            'node_modules/font-awesome/css/font-awesome.css',
            'node_modules/ionicons/dist/css/ionicons.css',
            'node_modules/admin-lte/dist/css/AdminLTE.css',
            'node_modules/admin-lte/plugins/iCheck/square/blue.css',
            'resources/assets/css/fonts.css',
            'resources/assets/css/login.css'
        ], 'public/css/login.css', './')
        .scripts([
            'node_modules/admin-lte/plugins/jQuery/jquery-2.2.3.min.js',
            'node_modules/admin-lte/bootstrap/js/bootstrap.js',
            'node_modules/datatables.net/js/jquery.dataTables.js',
            'node_modules/datatables.net-bs/js/dataTables.bootstrap.js',
            'node_modules/datatables.net-buttons/js/dataTables.buttons.js',
            'node_modules/datatables.net-buttons-bs/js/buttons.bootstrap.js',
            'node_modules/datatables.net-buttons/js/buttons.colVis.js',
            'node_modules/datatables.net-buttons/js/buttons.flash.js',
            'node_modules/datatables.net-buttons/js/buttons.html5.js',
            'node_modules/datatables.net-buttons/js/buttons.print.js',
            'node_modules/datatables.net-fixedcolumns/js/dataTables.fixedColumns.js',
            'node_modules/datatables.net-fixedheader/js/dataTables.fixedHeader.js',
            'node_modules/datatables.net-responsive/js/dataTables.responsive.js',
            'node_modules/datatables.net-responsive-bs/js/responsive.bootstrap.js',
            'node_modules/bootstrap/dist/sweetalert.js',
            'node_modules/sweetalert2/dist/sweetalert2.min.js',
            'node_modules/admin-lte/plugins/slimScroll/jquery.slimscroll.js',
            'node_modules/admin-lte/plugins/fastclick/fastclick.js',
            'node_modules/summernote/dist/summernote.js',
            'node_modules/admin-lte/plugins/datepicker/bootstrap-datepicker.js',
            'node_modules/admin-lte/plugins/datepicker/locales/bootstrap-datepicker.id.js',
            'node_modules/admin-lte/plugins/daterangepicker/moment.js',
            'node_modules/admin-lte/plugins/daterangepicker/daterangepicker.js',
            'node_modules/admin-lte/plugins/select2/select2.full.js',
            'node_modules/admin-lte/plugins/select2/i18n/id.js',
            'resources/assets/js/jquery.autocomplete.min.js',
            'resources/assets/js/bootstrap-switch/js/bootstrap-switch.js',
            'resources/assets/js/bootbox.min.js',
            'resources/assets/js/bootstrap-tagsinput.js',
            'resources/assets/js/papaparse.js',
            'node_modules/admin-lte/plugins/iCheck/icheck.js',
            'node_modules/admin-lte/dist/js/app.js',
           // 'public/js/app.js',
            'resources/assets/js/custom.js',
        ], 'public/js/all.js', './')
        .scripts([
            'node_modules/vue/dist/vue.min.js',
            'node_modules/vue-resource/dist/vue-resource.min.js',
        ], 'public/js/vue.js', './')
        .scripts([
            'resources/assets/js/po_sap.js',
        ], 'public/js/po_sap.js', './')
        .scripts([
            'resources/assets/js/po_dummy.js',
        ], 'public/js/po_dummy.js', './')
        .scripts([
            'resources/assets/js/pdfjs/pdf.worker.js',
        ], 'public/js/pdf.worker.js', './')
        .scripts([
            'resources/assets/js/pdfjs/pdf.js',
        ], 'public/js/pdf.js', './')
        .scripts([
            'resources/assets/js/pdf_view.js',
        ], 'public/js/pdf_view.js', './')
        .scripts([
            'node_modules/admin-lte/plugins/jQuery/jquery-2.2.3.min.js',
            'node_modules/admin-lte/bootstrap/js/bootstrap.js',
            'node_modules/admin-lte/plugins/iCheck/icheck.js',
        ], 'public/js/login.js', './');
        if (mix.inProduction()) {
		    mix.version();
		}
// mix.js('resources/assets/js/app.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css');
