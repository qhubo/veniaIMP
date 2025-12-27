<div class="row">
    <div class="col-lg-10"></div>
    <div class="col-lg-2">				
        <div class="kt-input-icon kt-input-icon--left">
            <input type="text" class="form-control" placeholder="Buscar..." id="generalSearch">
            <span class="kt-input-icon__icon kt-input-icon__icon--left">
                <span><i class="la la-search"></i></span>
            </span>
        </div>
    </div>
</div>
<!--<table class="table table-bordered  dataTable table-condensed flip-content" >-->
<table class="kt-datatable" id="html_table" width="100%">
    <thead class="flip-content">
        <tr class="active">
            <th align="center" >Fecha</th>
            <th  align="center"> Tipo</th>
            <th align="center" width="30px"> Código</th>
            <th align="center" width="30px"> Asiento</th>
            <th align="center" width="30px" style="text-align:center;"> Confirmada</th>
            <th  align="center"> Valor</th>
            <th>Accion</th>
            <th align="center" >Usuario</th>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0; ?>
        <?php foreach ($operaciones as $lista) { ?>
            <?php $url = "reporte_partida/partida?id=" . $lista->getId(); ?>
            <?php $tipoU = trim(str_replace(" ", "", $lista->getTipo())); ?>
            <?php if ($tipoU == "DebitoBanco") { ?> 
                <?php $url = "debito_banco/muestra?id=" . $lista->getCodigo(); ?>
            <?php } ?>
            <?php if ($tipoU == "TransferenciaBanco") { ?> 
                <?php $url = "debito_banco/muestra?id=" . $lista->getCodigo(); ?>
            <?php } ?>
            <?php if ($tipoU == "OrdenDevolución") { ?> 
                <?php $url = "orden_devolucion/vista?id=" . $lista->getCodigo(); ?>
            <?php } ?>
            <?php if ($tipoU == "VentaResumida") { ?> 
                <?php $arrayC = explode("-", $lista->getCodigo()); ?>
                <?php $url = "venta_resumida/vista?cod=" . $arrayC[1]; ?>
            <?php } ?> 
            <?php if ($tipoU == "Gasto") { ?> 
                <?php $url = "orden_gasto/vista?token=" . sha1($lista->getCodigo()); ?>
            <?php } ?>
            <?php if ($tipoU == "GastoCaja") { ?> 
                <?php $url = "orden_gasto/vista?cajaid=Caja" . $lista->getCodigo(); ?>
            <?php } ?> 
            <?php if ($tipoU == "PagoGasto") { ?> 
                <?php $arrayC = explode("GGAP", $lista->getCodigo()); ?>
                <?php $url = "pagos_realizado/vista?id=" . $arrayC[1]; ?>
            <?php } ?> 
            <tr>
                <td><?php echo $lista->getFechaContable('d/m/Y'); ?></td>
                <td>
                    <a href="<?php echo url_for($url) ?>" class=" btn-sm " data-toggle="modal" data-target="#ajaxmodalMO<?php echo $lista->getId(); ?>">
                        <?php echo $lista->getTipo(); ?>
                    </a>
                </td>
                <td>
                    <a href="<?php echo url_for("reporte_partida/partida?id=" . $lista->getId()) ?>" class="btn btn-block btn-sm btn-dark" data-toggle="modal" data-target="#ajaxmodal<?php echo $lista->getId(); ?>">  <?php echo $lista->getCodigo(); ?>    </a>
                </td>
                <td><?php echo $lista->getNoAsiento(); ?></td>
                <td style="text-align:center">
                    <?php if ($lista->getConfirmada()) { ?>
            <li class="fa fa-check"></li>
        <?php } ?>
    </td>
    <td style="text-align: right"><?php echo Parametro::formato($lista->getValor()); ?></td>
    <td style="text-align: center; align-content: center;">
        <a class="btn  btn-sm btn-danger" data-toggle="modal" href="#static<?php echo $lista->getId() ?>"><i class="fa fa-download"></i>   </a>
        <?php //if (date('Ym') == $lista->getFechaContable('Ym')) { ?> 
        <a target="_blank" href="<?php echo url_for("partida_manual/index?no=" . $lista->getId()) ?>" class="btn  btn-sm btn-dark" >  <li class="fa fa-edit"></li>   </a>
        <?php //} ?>
    </td>
    <td><?php echo $lista->getUsuario(); ?></td>
    </tr>

    <div id="static<?php echo $lista->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <li class="fa fa-cogs"></li>
                    <span class="caption-subject bold font-yellow-casablanca uppercase"> Desactivar Partida</span>
                </div>
                <div class="modal-body">
                    <p> Esta seguro de desactivar partida
                        <span class="caption-subject font-green bold uppercase"> 
                            <?php echo $lista->getCodigo() ?>
                        </span> ?
                    </p>
                </div>
                <?php $token = md5($lista->getCodigo()); ?>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                    <a class="btn  btn green " href="<?php echo url_for($modulo . '/elimina?token=' . $token . '&id=' . $lista->getId()) ?>" >
                        <i class="fa fa-download "></i> Confirmar</a> 
                </div>
            </div>
        </div>
    </div> 
<?php } ?>
</tbody>

</table>