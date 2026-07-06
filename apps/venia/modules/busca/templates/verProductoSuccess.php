<?php $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad'); ?>
<?php $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId); ?>
<?php $TIPO_USUARIO = strtoupper($usuarioQ->getTipoUsuario()); ?>
 <?php  $tiendaQuery = TiendaQuery::create()->filterByActivo(true);
        if ($TIPO_USUARIO != 'ADMINISTRADOR') {
            $tiendaQuery->filterByActivaBuscador(true);
        }
        $tiendaQuery->orderById();
        $tiendas = $tiendaQuery->find(); ?>
<?php $tipoPrecios  = ListaPrecioQuery::create()->filterByConfidencial(false)->orderByNombre() ->orderById()->filterByActivo(true)->find(); ?>
<?php $tipoPrecioscon  = ListaPrecioQuery::create()->filterByConfidencial(true)->orderByNombre() ->orderById()->filterByActivo(true)->find(); ?>

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
<style>

.tabla-scroll{
    width:100%;
    overflow-x:auto;
    overflow-y:auto;
    -webkit-overflow-scrolling:touch;
    max-height:75vh;
}

.tablaProductoIvent{
    min-width:1200px;
    width:100%;
    border-collapse:collapse;
}

.tablaProductoIvent th{
    position:sticky;
    top:0;
    background:#dff0d8;
    white-space:nowrap;
    text-align:center;
    font-size:13px;
}

.tablaProductoIvent td{
    white-space:nowrap;
    vertical-align:middle;
    font-size:13px;
}

@media(max-width:768px){

    .tabla-scroll{
        max-height:calc(100vh - 180px);
    }

    .tablaProductoIvent{

        min-width:900px;

        font-size:11px;

    }

    .tablaProductoIvent th{

        font-size:11px;
        padding:6px;

    }

    .tablaProductoIvent td{

        font-size:11px;
        padding:4px;

    }

}

</style>
<div class="alert alert-info text-center visible-xs">
    <i class="fa fa-arrows-h"></i>
    Desliza la tabla hacia la derecha para ver existencias y precios.
</div>
<div class="table-responsive tabla-scroll">
<table class="table table-striped table-bordered table-hover order-column  tablaProductoIvent"  >
    <thead>
        <tr class="success">
            <th>Codigo</th>
            <th >Nombre</th>
	    <?php foreach ($tiendas as $data) { ?>
                <th>Existencia <?php echo $data->getCodigo(); ?></th>
            <?php } ?>
            <th >Precio Venta</th>
               <?php foreach ($tipoPrecios as $data) { ?>
                <th > Precio <?php echo $data->getNombre(); ?></th>
            <?php } ?>
                
            <?php if ($TIPO_USUARIO == 'ADMINISTRADOR') { ?>

                   <?php foreach ($tipoPrecioscon as $data) { ?>
                <th > Precio <?php echo $data->getNombre(); ?></th>
            <?php } ?>
                <th > Costo </th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
  
    </tbody>
    <tfoot>
    </tfoot>
</table> 

</div>

<!-- /.modal-dialog -->

<!--<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/js/buscadores.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>-->
<!--<script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>-->
<script>

console.log("SCRIPT CARGADO");

$(function () {

    console.log("DOCUMENT READY");

});
</script>
<script>
    var oppTable = $('.tablaProductoIvent').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
  "sPaginationType": "full_numbers",
    "bProcessing": true,
    "bServerSide": true,
    "bStateSave": false,
    "bLengthChange": false,
    "searchDelay": 1300,
    "aLengthMenu": [[5,25,50,100,-1],[5,25,50,100,"Todos"]],
    "iDisplayStart": 500,
    "sAjaxSource": "/index.php/busca/tabJsProductoBusca?id=1",
            "aoColumns": [
            {"bSearchable": true},
            {"bSearchable": true},
<?php foreach ($tiendas as $data) { ?>
                {"bSearchable": true},
<?php } ?>
                 {"bSearchable": true},
    <?php foreach ($tipoPrecios as $data) { ?>
                {"bSearchable": true},
<?php } ?>

<?php if ($TIPO_USUARIO == 'ADMINISTRADOR') { ?>
                <?php foreach ($tipoPrecioscon as $data) { ?>
                    {"bSearchable": true} ,
                    <?php } ?>

    {"bSearchable": true} ,
<?php } ?>
   
            
            ],

    fnDrawCallback: function ()
    {
        //  this.parent().applyTemplateSetup();
    }
    ,
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