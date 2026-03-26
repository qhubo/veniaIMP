
<style>
.tabla-scroll {
    max-height: 400px;   /* Ajusta la altura */
    overflow-y: auto;
}

.tablaProductoIvent thead th {
    position: sticky;
    top: 0;
    background: #dff0d8; /* color success */
    z-index: 10;
}
</style>
<div class="table-responsive tabla-scroll">
<table class="table table-striped table-bordered table-hover order-column   tablaProductoIventario2"  >
    <thead>
        <tr class="success">
<!--            <th>Imagen</th>-->
            <th>Código</th>
            <th width="50%">Nombre</th>
            <th width="10%">Existencia</th>
        </tr>
    </thead>
    <tbody>
        <tr>
<!--            <td></td>-->
            <td></td>
            <td></td>
            <td></td>

        </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table> 
</div>


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
        "aLengthMenu": [[5, 25, 50, 500, -1], [5, 25, 500, 100, "Todos"]],
        "iDisplayStart": 500,
        "searchDelay": 1300,
        "sAjaxSource": "/index.php/busca/tabJsProductoCotiTodas?id=1",
        "aoColumns": [
            {"bSearchable": true},
            {"bSearchable": true},
            {"bSearchable": true},
//            {"bSearchable": true},
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