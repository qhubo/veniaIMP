<table  width="740px">
    <tr>
        <td  width="10px"> </td>
        <td>
            <table cellpadding="2" >
                <tr >
                    <th   align="left" width="100px">&nbsp;Nit </th>
                    <td  style="border: 0.2px solid #5E80B4;"width="345px">        <?php echo $orden->getNit() ?>  </td>
                    <td width="10px">&nbsp;</td>
                    <th  align="left" width="100px">&nbsp; </th>
                    <td  style="" width="170px">        <?php //echo $orden->getDiaCredito() ?>   </td>
                </tr>
                <tr>
                    <th  lign="left"  width="100px">&nbsp;Nombre </th>
                    <td  style="border: 0.2px solid #5E80B4;"width="345px">        <?php echo $orden->getNombre() ?> </td>
                    <td width="10px">&nbsp;</td>
                    <th  align="left" width="100px">&nbsp;Cliente </th>
                    <td   style="border: 0.2px solid #5E80B4;" width="170px">    <?php if ($orden->getClienteId()) { ?>   <?php echo $orden->getCliente()->getCodigo(); ?>    <?php } ?> </td>
                </tr> 

                <tr>
                    <th  align="left"  width="100px">&nbsp;Observaciones </th>
                    <td style="border: 0.2px solid #5E80B4;font-size:25px;"width="345px">        <?php echo $orden->getComentario() ?>  </td>
                    <td width="10px">&nbsp;</td>
                    <th align="left" width="100px">&nbsp;Usuario </th>
                    <td style="border: 0.2px solid #5E80B4;" width="170px">    <?php echo $orden->getUsuario(); ?> </td>
                </tr>
            </table>

            <br>
            <br>
<!--            <table cellpadding="2"  >
                <tr>


                    <th style="border: 0.2px solid #5E80B4;"  align="center" width="110px" >Fecha  Documento</th>
                    <th style="border: 0.2px solid #5E80B4;"  align="center" width="110px">Fecha  Vencimiento</th>
                    <th style="border: 0.2px solid #5E80B4;" align="center" width="100px">Sub Total</th>
                    <th  style="border: 0.2px solid #5E80B4;" align="center" width="85px">Iva</th>
                    <th  style="border: 0.2px solid #5E80B4;" align="center" width="120px">Total</th>

                </tr>
                <tr>

                    <td style="border: 0.2px solid #5E80B4;" align="center"><?php echo $orden->getFechaDocumento('d/m/Y') ?></td>
                    <td style="border: 0.2px solid #5E80B4;" align="center"><?php echo $orden->getFechaVencimiento('d/m/Y') ?></td>
                    <td style="border: 0.2px solid #5E80B4;" align="right"><?php echo number_format($orden->getSubTotal(), 2); ?> </td>
                    <td style="border: 0.2px solid #5E80B4;" align="right" ><?php echo number_format($orden->getIva(), 2); ?> </td>
                    <td style="border: 0.2px solid #5E80B4;" align="right"><h3><?php echo number_format($orden->getValorTotal(), 2); ?></h3> </td>
                </tr>
            </table>-->
<!--            <br>
            <br>-->
            <table   >
<!--                <br><br>-->
                <tr >
                    <th  align="center" width="25px" style="height: 20px; font-size:30px; border-left: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4; text-align: center; font-weight: bold;"># </th>
                    <th  align="center" width="130px" style="font-size:30px;border-left: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4; text-align: center;  font-weight: bold;">Codigo </th>
                    <th  align="center" width="300px"  style="font-size:30px; border-left: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4;text-align: center; font-weight: bold;">Descripción </th>
                    <th  align="center" width="100px"  style="font-size:30px;border-left: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4; text-align: center; font-weight: bold;">Valor Unitario </th>
                    <th  align="center" width="70px"  style="font-size:30px;border-left: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4; text-align: center; font-weight: bold;">Cantidad </th>
                    <th  align="center" width="95px"  style="border-right: 0.2px solid #5E80B4;font-size:30px; border-left: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4; text-align: center; font-weight: bold;">Valor Total </th>
                </tr>

                <?php $can = 0; ?>
                  <?php $total=0; ?>
                <?php foreach ($lista as $registro) { ?>
                  <?php $total=$total+$registro->getValorTotal(); ?>
                    <?php $can++; ?>
                    <tr>
                        <td width="25px" style="height: 15px;  font-size:25px;border-left: 0.2px solid #5E80B4;  ">&nbsp;<?php echo $can; ?> </td>
                        <td width="130px" style="font-size:25px;border-left: 0.2px solid #5E80B4;"> <?php
                            if ($registro->getProductoId()) {
                                echo $registro->getProducto()->getCodigoSku();
                            }
                            ?> <?php
                        if ($registro->getServicioId()) {
                            echo $registro->getServicio()->getCodigo();
                        }
                        ?></td>    
                        <td width="300px" style="font-size:35px;border-left: 0.2px solid #5E80B4;">&nbsp;&nbsp;<?php echo $registro->getDetalle(); ?></td> 
                        <td width="100px" style="text-align: right;font-size:35px;border-left: 0.2px solid #5E80B4;" ><?php echo number_format((float) ($registro->getValorUnitario()), 2, '.', ''); ?>&nbsp;&nbsp;</td>
                        <td width="70px"  style="text-align: right;font-size:35px;border-left: 0.2px solid #5E80B4;" ><?php echo $registro->getCantidad(); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td> 
                        <td width="95px" style="text-align: right;font-size:35px;border-left: 0.2px solid #5E80B4;border-right: 0.2px solid #5E80B4;" ><?php echo number_format((float) ($registro->getValorTotal()), 2, '.', ''); ?>&nbsp;&nbsp;</td>
                    </tr>
                    
                    <tr>
                        <td colspan="3" style="border-left: 0.2px solid #5E80B4;">
                            <?php  $ubicaciones = ProductoUbicacionQuery::create()->filterByCantidad(0, criteria::GREATER_THAN)->filterByProductoId($registro->getProductoId())->find(); ?>
                            
                            <table style="width: 100%">
                                <?php foreach($ubicaciones as $regi) { ?>
                                <tr>
                                    <td style="width:  250px;"></td>
                                    <td style="width:  100px;font-size:30px;"><?php echo $regi->getTienda()->getCodigo(); ?>&nbsp;&nbsp;<?php echo $regi->getUbicacion(); ?></td>
                                    <td style="width:  50px; font-size:30px; text-align: right;"><?php echo $regi->getCantidad(); ?>&nbsp;&nbsp;</td>                             
                                </tr>
                                <?php } ?>
                                
                            </table>
                            
                            
                        </td>
                        <td colspan="3" style="border-left: 0.2px solid #5E80B4; border-right: 0.2px solid #5E80B4;"></td>
                    </tr>
                    
<?php } ?>
                <tr>
                    <td style="border-top: 0.2px solid #5E80B4;"></td>
                    <td style="border-top: 0.2px solid #5E80B4;"></td>
                    <td style="border-top: 0.2px solid #5E80B4;"></td>
                 
                    <td colspan="2" style="border-top: 0.2px solid #5E80B4; font-weight: bold;font-size:35px;">VALOR TOTAL</td>
                    <td style="border-top: 0.2px solid #5E80B4;   font-weight: bold;font-size:35px;"> <?php echo Parametro::formato($total); ?></td>
                </tr>

            </table>

  <?Php $tipoDocumento = "Cotizacion"; ?>
 <?php include_partial('soporte/valorCampoReporte', array('tipoDocumento' => $tipoDocumento, 'idDoc' => $orden->getId())) ?> 
   


        </td>     
    </tr>
</table>