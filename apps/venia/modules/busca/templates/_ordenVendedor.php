
            <table class="table table-striped table-bordered table-hover order-column  tablaProductoIventario2"  >
                <thead>
                    <tr class="success">
<!--                        <th>Imagen</th>-->
                        <th>Código</th>
                        <th width="50%">Nombre</th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
<!--                        <td></td>-->
                        <td></td>
                        <td></td>
                        <td></td>

                    </tr>
                </tbody>
                <tfoot>
                </tfoot>
            </table> 
    


<!-- /.modal-dialog -->

<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<!--<script src="/js/buscadores.js" type="text/javascript"></script>-->
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<!--<script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>-->

<script>
    var oppTable = $('.tablaProductoIventario2').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bServerSide": true,
        "bStateSave": false,
        "bLengthChange": false,
        "aLengthMenu": [[5, 25, 50, 100, -1], [5, 25, 50, 100, "Todos"]],
        "iDisplayStart": 5,
        "sAjaxSource": "/index.php/busca/tabJsProductoVendedor?movi=<?php echo $movi; ?>",
        "aoColumns": [
//            {"bSearchable": true},
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


</script>