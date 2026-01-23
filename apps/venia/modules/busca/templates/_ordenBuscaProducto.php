<?php $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad'); ?>
<?php $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId); ?>
<?php $TIPO_USUARIO = strtoupper($usuarioQ->getTipoUsuario()); ?>
<?php $tiendas = TiendaQuery::create()->filterByActivo(true)->find(); ?>
<?php  //if ($TIPO_USUARIO != 'ADMINISTRADOR') {  ?>
<?php $tiendas = TiendaQuery::create()->filterByActivo(true)->filterByActivaBuscador(true)->find(); ?>
<?php //} ?>

<?php $tipoPrecios  = ListaPrecioQuery::create()->orderByNombre()->filterByActivo(true)->find(); ?>
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
<table class="table table-striped table-bordered table-hover order-column  tablaProductoIvent"  >
    <thead>
        <tr class="success">
            <th>Código</th>
            <th width="50%">Nombre</th>
            <?php foreach ($tiendas as $data) { ?>
                <th width="10%"><?php echo $data->getCodigo(); ?></th>
            <?php } ?>

            <th width="10%">Precio</th>
               <?php foreach ($tipoPrecios as $data) { ?>
                <th width="10%"><?php echo $data->getNombre(); ?></th>
            <?php } ?>
            <?php if ($TIPO_USUARIO == 'ADMINISTRADOR') { ?>
                <th width="10%"></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td></td>
            <td></td>
         
            <td></td>            
                <?php if ($TIPO_USUARIO == 'ADMINISTRADOR') { ?>
                <th width="10%"></th>
            <?php } ?>
                

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
    var oppTable = $('.tablaProductoIvent').dataTable({
//  sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
    "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false,
            "bLengthChange": false,
            "aLengthMenu": [[5, 25, 50, 100, - 1], [5, 25, 50, 100, "Todos"]],
            "iDisplayStart": 5,
            "sAjaxSource": "/index.php/busca/tabJsProductoBusca?id=1",
            "aoColumns": [
            {"bSearchable": true},
            {"bSearchable": true},
<?php foreach ($tiendas as $data) { ?>
                {"bSearchable": true},
<?php } ?>
    <?php foreach ($tipoPrecios as $data) { ?>
                {"bSearchable": true},
<?php } ?>
    
<?php if ($TIPO_USUARIO == 'ADMINISTRADOR') { ?>
                {"bSearchable": true}
                ,
<?php } ?>
            {"bSearchable": true}
            ,
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