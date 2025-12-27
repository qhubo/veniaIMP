jQuery(document).ready(function () {
    var asInitVals = new Array();
    jQuery(document).ready(function () {
       var oppTable = $('.tablaProductoIventario').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [5, 25, 50, 100, "Todos"]],
            "iDisplayStart": 5,
            "sAjaxSource": "/index.php/buscador/tabJsProducto",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });
       var oppTable1 = $('.tablaBuscaProveedor').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            "sAjaxSource": "/index.php/buscador/tabJsProveedor",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });
        
        
 
        
                    var oppTable1996 = $('.tablaProductoIngreso122').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [5, 25, 50, 100, "Todos"]],
            "iDisplayStart": 5,
            "sAjaxSource": "/index.php/buscador/tabJsProductoIngresoPro",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
            
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });
        
        
        
        
             var oppTable199 = $('.tablaProductoSalida122').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [5, 25, 50, 100, "Todos"]],
            "iDisplayStart": 5,
            "sAjaxSource": "/index.php/buscador/tabJsProductoSalidaPro",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
            
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });
        
        
        
        
        
        
       var oTable1 = $('.tablaProductoIventario2').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            "sAjaxSource": "/index.php/buscador/tabJsProducto",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });
       var oTable2 = $('.tablaProductoIventario3').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            "sAjaxSource": "/index.php/buscador/tabJsProducto",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });
       var oTable3 = $('.tablaProductoIventario4').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            "sAjaxSource": "/index.php/buscador/tabJsProducto",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });
       var oTable4 = $('.tablaProductoIventario5').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            "sAjaxSource": "/index.php/buscador/tabJsProducto",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });
       var oTable4 = $('.tablaProductoIventario6').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            "sAjaxSource": "/index.php/buscador/tabJsProducto",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });

            var oppTable607 = $('.tablaProductoClientePosn').dataTable({
//    sDom: '<"top"i>rt<"bottom"flp><"clear">',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            "sAjaxSource": "/index.php/buscador/tabJsClientePosn",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });
    var oppTable67 = $('.tablaProductoClientePosf').dataTable({
//    sDom: '<"top"i>rt<"bottom"flp><"clear">',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            "sAjaxSource": "/index.php/buscador/tabJsClientePosf",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });
    var oppTable6 = $('.tablaProductoClientePos').dataTable({
//    sDom: '<"top"i>rt<"bottom"flp><"clear">',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            "sAjaxSource": "/index.php/buscador/tabJsClientePos",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });
        
        
                 var oppTable77 = $('.tablaPendientePosf').dataTable({
//    sDom: '<"top"i>rt<"bottom"flp><"clear">',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            "sAjaxSource": "/index.php/buscador/tabJsPendientePosf",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });
         var oppTable7 = $('.tablaPendientePos').dataTable({
//    sDom: '<"top"i>rt<"bottom"flp><"clear">',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
            "sAjaxSource": "/index.php/buscador/tabJsPendientePos",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });
        
        var oppTable8 = $('.tablaProductoPos').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [5, 25, 50, 100, "Todos"]],
            "iDisplayStart": 5,
            "sAjaxSource": "/index.php/buscador/tabJsProductoPos",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });


  var oppTable199 = $('.tablaProductoSalida1').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [5, 25, 50, 100, "Todos"]],
            "iDisplayStart": 5,
            "sAjaxSource": "/index.php/buscador/tabJsProductoSalida1",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
            
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });
        
        
    
       var oppTable299 = $('.tablaProductoSalida2').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [5, 25, 50, 100, "Todos"]],
            "iDisplayStart": 5,
            "sAjaxSource": "/index.php/buscador/tabJsProductoSalida2",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
          
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });
        
        
        
  var oppTable99 = $('.tablaProductoSalidaE').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [5, 25, 50, 100, "Todos"]],
            "iDisplayStart": 5,
            "sAjaxSource": "/index.php/buscador/tabJsProductoSalidaE",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
      //          {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });
        
  var oppTable9 = $('.tablaProductoSalida').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [5, 25, 50, 100, "Todos"]],
            "iDisplayStart": 5,
            "sAjaxSource": "/index.php/buscador/tabJsProductoSalida",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
         //       {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });

        
          var oppTable29 = $('.tablaProductoCupon').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, -1], [5, 25, 50, 100, "Todos"]],
            "iDisplayStart": 5,
            "sAjaxSource": "/index.php/buscador/tabJsProductoCupon",
            "aoColumns": [
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
//                {"bSearchable": true},
            ],

            fnDrawCallback: function ()
            {
                //  this.parent().applyTemplateSetup();
            },
            fnInitComplete: function ()
            {
                //this.parent().applyTemplateSetup();
                var oSettings = this.fnSettings();
                for (var i = 0; i < oSettings.aoPreSearchCols.length; i++) {
                    if (oSettings.aoPreSearchCols[i].sSearch.length > 0) {
                        $("tfoot input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        $("tfoot input")[i].className = "";
                    }
                }
            }
        });

        $("tfoot input").keyup(function () {
            /* Filter on the column (the index) of this element */
            oTable.fnFilter(this.value, $("tfoot input").index(this));
        });
        $("tfoot input").each(function (i) {
            asInitVals[i] = this.value;
        });
        $("tfoot input").focus(function () {
            if (this.className == "search_init")
            {
                this.className = "";
                this.value = "";
            }
        });
        $("tfoot input").blur(function (i) {
            if (this.value == "")
            {
                this.className = "search_init";
                this.value = asInitVals[$("tfoot input").index(this)];
            }
        });
    });

});