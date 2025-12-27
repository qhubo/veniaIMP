        
<div class="row" style="padding-top: 20px; padding-bottom: 20px;">
    <div class="col-lg-12"> 
        <div class="table-scroll-container" style="width: 100%;">
            
            <!-- Scroll superior -->
            <div class="table-scroll-top" style="overflow-x: auto; overflow-y: hidden;">
                <div></div>
            </div>

            <!-- Scroll inferior (normal) -->
            <div class="table-scroll-bottom" style="overflow-x: auto;">
<table class="table table-striped- table-bordered table-hover table-checkable  no-footer dtr-inlin " width="100%">
    <thead >
        <tr class="active">
            <th  align="center"><span class="kt-font-success"> Fecha Pago</span></th>
            <th  align="center"><span class="kt-font-success">Recibo </span></th>
            <th  align="center"><span class="kt-font-success">Valor</span></th>
            <th  align="center"><span class="kt-font-success">Comisión  </span></th>
            <th  align="center"><span class="kt-font-success">Medio Pago</span></th>
            <th  align="center"><span class="kt-font-success">Banco Pago</span></th>
            <th  align="center"><span class="kt-font-success">No. Cuenta</span></th>
            <th  align="center"><span class="kt-font-success">Documento Pago</span></th>
            <th  align="center"><span class="kt-font-success">Fecha Documento Pago</span></th>
            <th  align="center"><span class="kt-font-success">Código Cliente </span></th>
            <th  align="center"><span class="kt-font-success">Nombre Factura</span></th>
            <th  align="center"><span class="kt-font-success">Firma Factura </span></th>
            <th  align="center"><span class="kt-font-success">Fecha Factura </span></th>

    
            <th  align="center"><span class="kt-font-success">Código Factura </span></th>
            <th  align="center"><span class="kt-font-success">Estatus Factura </span></th>
            <th  align="center"><span class="kt-font-success">Valor Factura</span></th>
            <th  align="center"><span class="kt-font-success">Vendedor Factura</span></th>
            <th  align="center"><span class="kt-font-success">Usuario Factura</span></th>
        </tr>
    </thead>
    <tbody>
        <?php $conta = 0; ?>
        <?php foreach ($registros as $reg) { ?>
            <?php //$data = $reg->getGasto(); ?>
            <?php $conta++; ?>
            <tr>
                <td><?php echo $reg['fecha_creo']; ?></td>
                <td>
                           <a target="_blank" href="<?php echo url_for('lista_cobro/reporte?id=' . $reg['recibo']) ?>" class="btn btn-block btn-xs btn-info " target = "_blank">
                
                    <?php echo OperacionPago::Codigo($reg['recibo']); ?>
                           </a>
                           </td>
                <td style="font-weight: bold; font-size: 15px;"><?php echo Parametro::formato($reg['valor'],2); ?></td>
                <td><?php echo Parametro::formato($reg['comision'],2); ?></td>
                <td><?php echo $reg['tipoPago']; ?></td>
                <td><?php echo $reg['banco']; ?></td>
                <td><?php echo $reg['cuenta']; ?></td>
                <td><?php echo $reg['documento']; ?></td>
                <td><?php echo $reg['fecha_documento']; ?></td>
                <td><?php if ($reg['codigo_cliente'] <> "CONTRAENTREGA")  echo $reg['codigo_cliente']; ?></td>
                <td><?php echo $reg['nombre']; ?></td>
                <td><?php echo $reg['face_firma']; ?></td>
                <td><?php echo $reg['fechaFactura']; ?></td>
                
                        
<td><?php echo $reg['factura']; ?></td>
                <td><?php echo $reg['estatus']; ?></td>
                <td><?php echo Parametro::formato($reg['valor_factura'],2); ?></td>
                <td><?php echo $reg['vendedor']; ?></td>
   <td><?php echo $reg['usuario']; ?>
                           <a class="btn  btn-sm btn-danger" data-toggle="modal" href="#static<?php echo $reg['recibo'] ?>">   </a>

   </td>
            </tr>
            <?php } ?>

    </tbody>
</table>

</div>
</div>
</div>

    </div>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        const topScroll = document.querySelector('.table-scroll-top');
        const bottomScroll = document.querySelector('.table-scroll-bottom');

        // Sincroniza ambos scrolls
        const innerDiv = topScroll.querySelector('div');
        innerDiv.style.width = bottomScroll.scrollWidth + 'px';

        topScroll.addEventListener('scroll', function() {
            bottomScroll.scrollLeft = topScroll.scrollLeft;
        });
        bottomScroll.addEventListener('scroll', function() {
            topScroll.scrollLeft = bottomScroll.scrollLeft;
        });
    });
</script>

    <?php foreach ($registros as $reg) { ?>
    <div id="static<?php echo $reg['recibo'] ?>" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <li class="fa fa-cogs"></li>
                                <span class="caption-subject bold font-yellow-casablanca uppercase"> Eliminar Usuario</span>
                            </div>
                            <div class="modal-body">
                                <p> Esta seguro de eliminar Pago Recibo
                                    <span class="caption-subject font-green bold uppercase"> 
                                           <?php echo OperacionPago::Codigo($reg['recibo']); ?>
                                    </span> ?
                                </p>
                            </div>
                            <?php $token = md5($reg['recibo']); ?>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                                <a class="btn  btn btn-danger btn-sm " href="<?php echo url_for('pago_recibido/elimina?token=' . $token . '&id=' . $reg['recibo']) ?>" >
                                    Confirmar</a> 
                            </div>
                        </div>
                    </div>
                </div> 
   <?php } ?>


<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  