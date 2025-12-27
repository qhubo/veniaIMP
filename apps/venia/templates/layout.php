<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4 & Angular 8
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<?php $modulo = $sf_params->get('module'); ?>
<?php $action = $sf_params->get('action'); ?>
<?php $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad'); ?>
<html lang="en">
    <!-- begin::Head -->

    <head><!--begin::Base Path (base relative path for assets of this page) -->
        <base href="../../../../"><!--end::Base Path -->
        <meta charset="utf-8" />
        <title>Venia Link</title>
        <meta name="description" content="Faq ">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--begin::Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"> <!--end::Fonts -->
        <!--begin::Page Custom Styles(used by this page) -->
        <link href="./assets/app/custom/pages/faq/faq-1.css" rel="stylesheet" type="text/css" />
        <!--end::Page Custom Styles -->

        <!--begin:: Global Mandatory Vendors -->
        <link href="./assets/vendors/general/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" type="text/css" />
        <!--end:: Global Mandatory Vendors -->

        <!--begin:: Global Optional Vendors -->
        <link href="./assets/vendors/general/tether/dist/css/tether.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/bootstrap-timepicker/css/bootstrap-timepicker.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/select2/dist/css/select2.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/ion-rangeslider/css/ion.rangeSlider.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/nouislider/distribute/nouislider.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/owl.carousel/dist/assets/owl.carousel.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/owl.carousel/dist/assets/owl.theme.default.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/quill/dist/quill.snow.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/summernote/dist/summernote.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/animate.css/animate.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/toastr/build/toastr.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/dual-listbox/dist/dual-listbox.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/morris.js/morris.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/sweetalert2/dist/sweetalert2.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/socicon/css/socicon.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/custom/vendors/line-awesome/css/line-awesome.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/custom/vendors/flaticon/flaticon.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/custom/vendors/flaticon2/flaticon.css" rel="stylesheet" type="text/css" />
        <link href="./assets/vendors/general/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
        <link href="./assets/css/demo9/style.bundle_2.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="./images/favicon.png" />
        <link href="./css/kunesStyle.css" rel="stylesheet" type="text/css" />
    </head>

    <body class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--left kt-aside--fixed kt-page--loading">
        <?php include_partial('inicio/mobile') ?>
        <!-- end:: Header Mobile -->
        <div class="kt-grid kt-grid--hor kt-grid--root">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                    <?php $condomi = sfContext::getInstance()->getUser()->getAttribute("nombrelinea", null, 'seguridad'); ?>
                    <?php $nombreTienda = sfContext::getInstance()->getUser()->getAttribute("nombreTienda", null, 'seguridad'); ?>

                    <!-- begin:: Header -->
                    <div id="kt_header" class="kt-header  kt-header--fixed " data-ktheader-minimize="on">
                        <div class="kt-container  kt-container--fluid ">
                            <!-- begin: Header Menu -->
                            <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
                            <!--                                        <button type="button" class="btn btn-bold btn-label-info btn-sm" data-toggle="modal" data-target="#kt_modal_t"><?php echo $condomi; ?></button> 
                            -->



                            <?php //include_partial('inicio/menu') 
                            ?>

                            <?php include_partial('inicio/menuDinamico') ?>


                            <!-- end: Header Menu -->
                            <!-- begin:: Brand -->
                            <div class="kt-header__topbar kt-grid__item">
                                <?php if ($modulo != 'crea_cheque') { ?>
                                    <?php include_partial('inicio/btnmenu') ?>
                                <?php } ?>
                            </div>
                            <div class="kt-header__brand   kt-grid__item" id="kt_header_brand">
                                <a href="<?php echo url_for('busqueda_producto/index') ?>" class="btn btn-sm" > 
🔍 Buscador 
        </a>

                                <a href="#" data-toggle="modal" data-target="#kt_modal_t">
                                    <img height="65px" alt="Logo" src="<?php echo sfContext::getInstance()->getUser()->getAttribute("imagen", null, 'seguridad'); ?>" />
                                </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <?php if (($modulo <> 'carga_producto')) { ?>
                                    <a href="#" class="btn " data-toggle="modal" data-target="#kt_modal_bus">
                                        <i class="flaticon-search"></i>
                                    </a>
                                <?php } ?>

                            </div>
                            <div class="kt-header__topbar kt-grid__item">


                                <!--begin: User bar -->
                                <?php include_partial('inicio/user') ?>
                                <!--end: User bar -->
                                <!--begin: Quick panel toggler -->
                                <?php include_partial('inicio/quickpanel') ?>
                                <div class="kt-header__topbar-item dropdown">
                                    <div class="kt-header__topbar-wrapper">
                                        <span class="kt-header__topbar-icon kt-font-info ">
                                            <a href="<?php echo url_for('seguridad/logout') ?>"> <i class="flaticon-logout"> </i> </a>
                                        </span>
                                    </div>
                                </div>
                                <!--end: Quick panel toggler -->
                            </div>
                            <!-- end:: Header Topbar -->
                        </div>
                    </div>
                    <!-- end:: Header -->
                    <!-- begin:: Aside -->


                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4"></div>

                        <div class="col-md-2">
                            <a href="<?php echo url_for('inicio/index') ?>"> <img src="/images/LogoMakr.png" height="35px">
                            </a>
                        </div>
                        <div class="col-md-1"></div>

                        <div class="col-md-2" style="text-align: right">



                            <a class="btn btn-block btn-sm " href="#" data-toggle="modal" data-target="#kt_modal_tienda">

                                <?php echo strtoupper($nombreTienda); ?>&nbsp;&nbsp;&nbsp;
                            </a>
                        </div>


                    </div>

                    <?php $contiene = true; ?>
                    <?php if ($modulo == 'venta_resumida') { ?>
                        <?php $contiene = false; ?>
                    <?php } ?>
                    <?php if ($modulo == 'cuenta_saldo') { ?>
                        <?php $contiene = false; ?>
                    <?php } ?>
                    <?php if ($modulo == 'pago_recibido') { ?>
                        <?php $contiene = false; ?>
                    <?php } ?>

                    <?php if ($modulo == 'reporte_venta_producto') { ?>
                        <?php $contiene = false; ?>
                    <?php } ?>

                    <?php if ($modulo == 'consulta_venta') { ?>
                        <?php $contiene = false; ?>
                    <?php } ?>

                    <?php if ($modulo == 'reporte_moroso') { ?>
                        <?php $contiene = false; ?>
                    <?php } ?>
     <?php if ($modulo == 'reporte_kardex') { ?>
                        <?php $contiene = false; ?>
                    <?php } ?>

                    <?php if ($contiene) { ?>
                        <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
                            <div class="kt-container  kt-grid__item kt-grid__item--fluid">
                            <?php } ?>
                            <?php if ($_SERVER['SERVER_NAME'] == "venia") { ?>
                                <div class="row">
                                    <div class="col-md-12" style="color:white; background-color:greenyellow; text-align: center; align-content: center">
                                        <font size="+2"> ** PORTAL PRUEBAS * </font>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php include_partial('soporte/avisos') ?>
                            <?php echo $sf_content ?>
                            <?php if ($contiene) { ?>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- begin:: Footer -->
                    <?php include_partial('inicio/footer') ?>
                    <!-- end:: Footer -->
                </div>
            </div>
        </div>
        <!-- end:: Page -->
        <!-- begin::Quick Panel -->
        <?php include_partial('inicio/nota') ?>
        <!-- end::Quick Panel -->
        <!-- begin::Scrolltop -->
        <div id="kt_scrolltop" class="kt-scrolltop">
            <i class="fa fa-arrow-up"></i>
        </div>
        <!-- end::Scrolltop -->
        <!-- begin::Sticky Toolbar -->
        <?php // include_partial('inicio/toolbarDerecho') 
        ?>
        <!-- end::Sticky Toolbar -->
        <!-- begin::Demo Panel -->
        <?php // include_partial('inicio/muestratool') 
        ?>
        <!-- end::Demo Panel -->
        <!--Begin:: Chat-->
        <?php include_partial('inicio/modal') ?>

        <!--ENd:: Chat-->

        <!-- begin::Global Config(global config for global JS sciprts) -->
        <!--        <script>
                var KTAppOptions = {"colors": {"state": {"brand": "#591df1", "light": "#ffffff", "dark": "#282a3c", "primary": "#5867dd", "success": "#34bfa3", "info": "#36a3f7", "warning": "#ffb822", "danger": "#fd3995"}, "base": {"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"], "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]}}};
            </script>-->
        <!-- end::Global Config -->
        <!--begin:: Global Mandatory Vendors -->
        <script src="./assets/vendors/general/jquery/dist/jquery.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/popper.js/dist/umd/popper.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/js-cookie/src/js.cookie.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/moment/min/moment.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/sticky-js/dist/sticky.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/wnumb/wNumb.js" type="text/javascript"></script>
        <!--end:: Global Mandatory Vendors -->

        <!--begin:: Global Optional Vendors -->
        <script src="./assets/vendors/general/jquery-form/dist/jquery.form.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/block-ui/jquery.blockUI.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/custom/js/vendors/bootstrap-timepicker.init.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/bootstrap-maxlength/src/bootstrap-maxlength.js" type="text/javascript"></script>
        <script src="./assets/vendors/custom/vendors/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/bootstrap-switch/dist/js/bootstrap-switch.js" type="text/javascript"></script>
        <script src="./assets/vendors/custom/js/vendors/bootstrap-switch.init.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/select2/dist/js/select2.full.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/ion-rangeslider/js/ion.rangeSlider.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/typeahead.js/dist/typeahead.bundle.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/handlebars/dist/handlebars.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/inputmask/dist/jquery.inputmask.bundle.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/inputmask/dist/inputmask/inputmask.date.extensions.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/inputmask/dist/inputmask/inputmask.numeric.extensions.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/nouislider/distribute/nouislider.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/owl.carousel/dist/owl.carousel.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/autosize/dist/autosize.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/clipboard/dist/clipboard.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/dropzone/dist/dropzone.js" type="text/javascript"></script>
        <script src="./assets/vendors/custom/js/vendors/dropzone.init.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/quill/dist/quill.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/@yaireo/tagify/dist/tagify.polyfills.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/@yaireo/tagify/dist/tagify.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/summernote/dist/summernote.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/markdown/lib/markdown.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
        <script src="./assets/vendors/custom/js/vendors/bootstrap-markdown.init.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/bootstrap-notify/bootstrap-notify.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/custom/js/vendors/bootstrap-notify.init.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/jquery-validation/dist/jquery.validate.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/jquery-validation/dist/additional-methods.js" type="text/javascript"></script>
        <script src="./assets/vendors/custom/js/vendors/jquery-validation.init.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/toastr/build/toastr.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/dual-listbox/dist/dual-listbox.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/raphael/raphael.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/morris.js/morris.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/chart.js/dist/Chart.bundle.js" type="text/javascript"></script>
        <script src="./assets/vendors/custom/vendors/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/custom/vendors/jquery-idletimer/idle-timer.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/waypoints/lib/jquery.waypoints.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/counterup/jquery.counterup.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/es6-promise-polyfill/promise.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/sweetalert2/dist/sweetalert2.min.js" type="text/javascript"></script>
        <script src="./assets/vendors/custom/js/vendors/sweetalert2.init.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/jquery.repeater/src/lib.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/jquery.repeater/src/jquery.input.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/jquery.repeater/src/repeater.js" type="text/javascript"></script>
        <script src="./assets/vendors/general/dompurify/dist/purify.js" type="text/javascript"></script>
        <!--end:: Global Optional Vendors -->


        <!--begin::Global Theme Bundle(used by all pages) -->

        <script src="./assets/js/demo9/scripts.bundle.js" type="text/javascript"></script>
        <!--end::Global Theme Bundle -->
        <script src="./assets/js/demo9/pages/crud/metronic-datatable/base/html-tableESPANOL.js" type="text/javascript"></script>

        <?php $editor = false; ?>



        <?php if ($modulo == 'busca') { ?>
            <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
            <script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
            <script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <?php } ?>
        <?php if ($sf_request->getParameter('action') == 'test') { ?>
            <?php $editor = true; ?>
        <?php } ?>

        <?php if ($modulo == "formato_cheque") { ?>
            <?php if ($sf_request->getParameter('action') == 'muestra') { ?>
                <?php $editor = true; ?>
            <?php } ?>
        <?php } ?>
        <?php if ($modulo == "parametro") { ?>
            <?php $editor = true; ?>
        <?php } ?>
        <?php if ($editor) { ?>
            <script src="./assets/global/plugins/jquery.min.js" type="text/javascript"></script>
            <script src="./assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
            <script src="./assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
            <script src="./assets/pages/scripts/components-editors.min.js" type="text/javascript"></script>

        <?php } ?>
        <script>
            function validate(evt) {
                var theEvent = evt || window.event;
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);

                var regex = /[0-9]|\./;
                if (!regex.test(key)) {
                    theEvent.returnValue = false;
                    if (theEvent.preventDefault)
                        theEvent.preventDefault();
                }
            }
        </script>
        <script src="./js/veniaLink.js" type="text/javascript"></script>
    </body>
    <!-- end::Body -->

</html>