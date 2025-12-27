<?php $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad'); ?>
<?php $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId); ?>   
<?php $tipoUsua = sfContext::getInstance()->getUser()->getAttribute("tipoUsuario", null, 'seguridad'); ?>
<?php $usuarioa = sfContext::getInstance()->getUser()->getAttribute("usuarioNombre", null, 'seguridad'); ?>



<table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inlin "  width="100%">
<!-- <table class="kt-datatable" id="html_table" width="100%"> -->
    <thead >
        <tr class="active">
            <th  align="center"># </th>
            <th  align="center"> Fecha</th>
            <th  align="center"> Nombre</th>
            <th  align="center"> Ref. Factura </th>
            <th  align="center">Estatus</th>
            <th  align="center">Detalle </th>

            <th  align="center"> Concepto </th>
            <th  align="center"> Pago  </th>
            <th  align="center"> Valor  </th>
            <th  align="center">  Usuario </th>

            <th>Accion</th>

<!--            <th  align="center"> Autorizo </th>
            <th  align="center"> Vendedor </th>-->
        </tr>
    </thead>
    <tbody>
        <?php $conta = 0; ?>
        <?php $url = 'https://report.feel.com.gt/ingfacereport/ingfacereport_documento?uuid='; ?>
        <?php foreach ($registros as $data) { ?>
            <?php $data = OrdenDevolucionQuery::create()->findOneById($data->getId()); ?>
            <?php $conta++; ?>
            <?php $boton = false; ?>    
            <?php if (strtoupper($data->getEstatus()) == "NUEVO") { ?>
                <?php if ($data->getUsuarioCreo() == $usuarioQue->getUsuario()) { ?>
                    <?php $boton = true; ?>    
                <?php } ?>
            <?php } ?>
         
            <?php if (strtoupper($data->getEstatus()) == "ANULADO") { ?>
                <?php $boton = false; ?>   
            <?php } ?>
        
           <?php if ((strtoupper($tipoUsua) == 'ADMINISTRADOR') or (strtoupper($usuarioa) == 'LMARTINEZ')) { ?>
                <?php $boton = true; ?>   
            <?php } ?>
        <?php if ($data->getFechaConfirmo()) { ?>
            <?php if ($data->getFechaConfirmo('mY') != (date('mY'))) { ?>
                <?php $boton = false; ?>   
            <?php } ?>
        <?php } ?>
            <tr>
                <td>
                    <a class="btn btn-outline  btn-sm  btn-outline "  href="<?php echo url_for($modulo . "/vista?id=" . $data->getId()) ?>" data-toggle="modal" data-target="#ajaxmodal<?php echo $data->getId(); ?>">
                        <?php echo $data->getCodigo(); ?>
                    </a>
                </td>
                <td style="text-align: center"><?php echo $data->getFecha('d/m/Y'); ?></td>
                <td><?php echo $data->getNombre(); ?></td>
                <td style="text-align: right" >
                    <?php if ($data->getFirmaFactura()) { ?>
                        <a target="_blank" href="<?php echo $url . $data->getFirmaFactura() ?>" class="btn btn-outline-success" >                   
                        <?php } ?>
                        <?php echo $data->getReferenciaFactura(); ?>
                        <?php if ($data->getFirmaFactura()) { ?>

                        </a>               
                    <?php } ?>
                    <?php echo $data->getFechaFactura('d/m/Y'); ?>

                </td>
                <td style="text-align: right" >
                             <?php echo $data->getEstatus(); ?>

                </td>
                <td><?php echo $data->getDetalleMotivo(); ?> <br> <?php echo $data->getDetalleRepuesto(); ?></td>
                <td><?php echo $data->getConcepto(); ?></td>
                <td><?php echo $data->getPagoMedio(); ?></td>
                <th style="text-align: right" >

                    <font size="-1"><?php echo Parametro::formato($data->getValor()); ?></font>



                </th>
                <td>

                    <?php echo $data->getUsuarioCreo(); ?></td>

                <td>

                    <?php if ($boton) { ?>
                        <a class="btn   btn-sm btn-danger" data-toggle="modal" href="#static<?php echo $data->getId() ?>"><i class="fa fa-trash"></i>   </a>
                    <?php } ?>


                </td>

    <!--                <td>
                <?php echo $data->getUsuarioConfirmo(); ?>
              <br>
                <?php echo $data->getFechaConfirmo('d/m/Y'); ?>
          </td>
          <td><?php echo $data->getVendedor(); ?></td>-->
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php foreach ($registros as $data) { ?>
    <?php $lista = $data; ?>
    <div class="modal fade"  id="ajaxmodal<?php echo $data->getId(); ?>" tabindex="-1"  data-toggle="modal" data-target="#responsivemodal"
         role="dialog"  aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel6">Detalle Devolución  <?php echo $data->getId(); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    <div id="static<?php echo $data->getId() ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <li class="fa fa-cogs"></li>
                    <span class="caption-subject bold font-yellow-casablanca uppercase"> Anular Devoulucion
                </div>
                <div class="modal-body">
                    <p> Esta seguro de eliminar Devolucion
                        <span class="caption-subject font-green bold uppercase"> 
                            <?php echo $lista->getCodigo() ?>
                            ?
                    </p>
                </div>
                <?php $token = md5($lista->getCodigo()); ?>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                    <a class="btn btn-danger  " href="<?php echo url_for($modulo . '/elimina?token=' . $token . '&id=' . $lista->getId()) ?>" >
                        <i class="fa fa-trash-o "></i> Confirmar</a> 
                </div>
            </div>
        </div>
    </div>
<?php } ?>


<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  