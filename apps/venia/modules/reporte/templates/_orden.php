<table  width="740px">
    <tr>
        <td  width="10px"> </td>
        <td>
            <table cellpadding="2" >
                <tr >
                    <th   align="left" width="100px">&nbsp;Nit </th>
                    <td  style="border: 0.2px solid #5E80B4;"width="345px">        <?php //echo $orden->getProveedor()->getNit() ?>  </td>
                    <td width="10px">&nbsp;</td>
                    <th  align="left" width="100px">&nbsp;Crédito </th>
                    <td  style="border: 0.2px solid #5E80B4;"width="170px">        <?php echo $orden->getDiaCredito() ?> Días   </td>
                </tr>
                <tr>
                    <th  lign="left"  width="100px">&nbsp;Nombre </th>
                    <td  style="border: 0.2px solid #5E80B4;"width="345px">        <?php echo $orden->getNombre() ?> </td>
                    <td width="10px">&nbsp;</td>
                    <th  align="left" width="100px">&nbsp;Proveedor </th>
                    <td   style="border: 0.2px solid #5E80B4;" width="170px">    <?php if ($orden->getProveedorId()) { ?>   <?php echo $orden->getProveedor()->getCodigo(); ?>    <?php } ?> </td>
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
            <table cellpadding="2"  >
                <tr>

                    <th  style="border: 0.2px solid #5E80B4;"  align="center" width="200px">Documento </th>
                    <th style="border: 0.2px solid #5E80B4;"  align="center" width="110px" >Fecha  Documento</th>
                    <th style="border: 0.2px solid #5E80B4;" align="center" width="100px">Sub Total</th>
                    <th  style="border: 0.2px solid #5E80B4;" align="center" width="85px">Iva</th>
                    <th  style="border: 0.2px solid #5E80B4;" align="center" width="120px">Total</th>

                </tr>
                <tr>
                    <td style="border: 0.2px solid #5E80B4;"><?php echo $orden->getSerie() ?> <?php echo $orden->getNoDocumento() ?> </td>
                    <td style="border: 0.2px solid #5E80B4;" align="center"><?php echo $orden->getFechaDocumento('d/m/Y') ?></td>
                    <td style="border: 0.2px solid #5E80B4;" align="right"><?php echo Parametro::formato($orden->getSubTotal(), 2); ?> </td>
                    <td style="border: 0.2px solid #5E80B4;" align="right" ><?php echo Parametro::formato($orden->getIva(), 2); ?> </td>
                    <td style="border: 0.2px solid #5E80B4;" align="right"><h3><?php echo Parametro::formato($orden->getValorTotal(), 2); ?></h3> </td>
                </tr>
                
                
                   <?php if ($orden->getValorImpuesto()) { ?>
                 <tr>
              
                     <td></td>
                <td></td>
                <td>ISR</td>
                <td>Valor Retenido</td>
                <td></td>
                <td style="text-align: right"> <?php echo Parametro::formato($orden->getValorImpuesto() * -1);  ?> </td>
          
            </tr>
                 <tr>
                <td></td>
                <td></td>
           
               
                <td colspan="3" style="text-align: right"><strong> <font size="+2">VALOR PAGAR</font></strong> </td>

                <td> <div style="text-align: right"><strong> <font size="+2"> <?php echo Parametro::formato($orden->getValorTotal()+$orden->getValorImpuesto() * -1); //, 2, '.', '');  ?></font></strong></div> </td>
          
            </tr>
        
        <?php } ?>
            
            
            
            </table>
            <br>
            <br>
            <table   >
                <br><br>
                <tr>
<!--                    <th  align="center" width="10px" style="font-size:30px; border-left: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4; text-align: center; font-weight: bold"># </th>-->
                    <th  align="center" width="120px" style="font-size:30px;border-left: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4; text-align: center; font-weight: bold">Codigo </th>
                    <th  align="center" width="225px"  style="font-size:30px; border-left: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4;text-align: center; font-weight: bold">Descripción </th>
                    <th  align="center" width="100px"  style="font-size:30px;border-left: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4; text-align: center; font-weight: bold">Valor Unitario </th>
                    <th  align="center" width="90px"  style="font-size:30px;border-left: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4; text-align: center; font-weight: bold">Cantidad </th>
                    <th  align="center" width="100px"  style="font-size:30px; border-left: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4; text-align: center; font-weight: bold">Valor Total </th>
                    <th width="80px"  style="font-size:30px; border-left: 0.2px solid #5E80B4; border-right: 0.2px solid #5E80B4; border-top: 0.2px solid #5E80B4;text-align: center; font-weight: bold">Iva</th>
                </tr>
        
     
                  <tr>
<!--                    <td style="border-top: 0.2px solid #5E80B4;border-left: 0.2px solid #5E80B4;"></td>-->
                    <td style="border-top: 0.2px solid #5E80B4;border-left: 0.2px solid #5E80B4;"></td>
                    <td style="border-top: 0.2px solid #5E80B4;border-left: 0.2px solid #5E80B4;"></td>
                    <td style="border-top: 0.2px solid #5E80B4;border-left: 0.2px solid #5E80B4;"></td>
                    <td style="border-top: 0.2px solid #5E80B4;border-left: 0.2px solid #5E80B4;"></td>
                    <td style="border-top: 0.2px solid #5E80B4;border-left: 0.2px solid #5E80B4;"></td>
                    <td style="border-top: 0.2px solid #5E80B4;border-left: 0.2px solid #5E80B4;border-right: 0.2px solid #5E80B4;"></td>
                </tr>
                

                <?php $can = 0; ?>
                <?php foreach ($lista as $registro) { ?>
                    <?php $can++; ?>
                    <tr>
<!--                        <td width="10px" style="font-size:25px;border-left: 0.2px solid #5E80B4; padding-top: 10px;  "><?php echo $can; ?> </td>-->
                        <td width="120px" style="font-size:25px;border-left: 0.2px solid #5E80B4;  padding-top: 10px;"> <?php
                            if ($registro->getProductoId()) {
                                echo substr($registro->getProducto()->getCodigoSku(),-6);
                            }
                            ?> <?php
                        if ($registro->getServicioId()) {
                            echo substr($registro->getServicio()->getCodigo(),-6);
                        }
                        ?></td>    
                        <td width="225px" style="font-size:25px;border-left: 0.2px solid #5E80B4; padding-top: 10px;">&nbsp;&nbsp;<?php echo $registro->getDetalle(); ?></td> 
                        <td width="100px" style="text-align: right;font-size:25px;border-left: 0.2px solid #5E80B4; padding-top: 10px;" ><?php echo number_format((float) ($registro->getValorUnitario()), 2, '.', ''); ?>&nbsp;&nbsp;</td>

                        <td width="90px"  style="text-align: right;font-size:25px;border-left: 0.2px solid #5E80B4;" ><?php echo $registro->getCantidad(); ?>&nbsp;&nbsp;</td> 
                        <td width="100px" style="text-align: right;font-size:25px;border-left: 0.2px solid #5E80B4;" ><?php echo Parametro::formato($registro->getValorTotal()) ?>&nbsp;&nbsp;</td>
                        <td width="80px" style="text-align: right;font-size:25px;border-left: 0.2px solid #5E80B4;border-right: 0.2px solid #5E80B4;" ><?php echo Parametro::formato($registro->getTotalIva()); ?>&nbsp;&nbsp;</td>

                    </tr>
                    <tr>
                          <td colspan="2"  width="220px" style="border-bottom:  0.2px solid #5E80B4; font-size:25px;border-left: 0.2px solid #5E80B4;  "></td>
                          <td  width="495px" colspan="5" style="font-size:25px; text-align: left; border-bottom:  0.2px solid #5E80B4; border-right:  0.2px solid #5E80B4;"><?php echo html_entity_decode($registro->getObservaciones()); ?> </td>
                    </tr>
                    
<?php } ?>
                <tr>
<!--                    <td style="border-top: 0.2px solid #5E80B4;"></td>-->
                    <td style="border-top: 0.2px solid #5E80B4;"></td>
                    <td style="border-top: 0.2px solid #5E80B4;"></td>
                    <td style="border-top: 0.2px solid #5E80B4;"></td>
                    <td style="border-top: 0.2px solid #5E80B4;"></td>
                    <td style="border-top: 0.2px solid #5E80B4;"></td>
                    <td style="border-top: 0.2px solid #5E80B4;"></td>
                </tr>

            </table>

  <?Php $tipoDocumento = "OrdenCompra"; ?>
 <?php include_partial('soporte/valorCampoReporte', array('tipoDocumento' => $tipoDocumento, 'idDoc' => $orden->getId())) ?> 
   

        </td>     
    </tr>
</table>


<br><br><br><br>
<?php $b = "0.2px solid #263663"; ?>
<table cellspacing="0" cellpadding="3"   width="742px">
    
        <tr>
        <td width="40px"></td>
        <td width="140px" style="text-align:right" class="titulo">&nbsp;Usuario:</td>
        <td width="180px" style="border-bottom: <?php echo $b; ?>" >&nbsp;<?php echo $orden->getUsuario (); ?></td>
        <td  width="2px"></td>
        <td width="70px" class="titulo">&nbsp;Fecha:</td>
        <td  width="90px"  style="border-bottom: <?php echo $b; ?>" >&nbsp;<?php echo $orden->getFechaDocumento ('d/m/Y'); ?></td>
        <td  width="2px"></td>
    </tr>

    <tr>
        <td width="40px"></td>
        <td width="140px" style="text-align:right" class="titulo">&nbsp;Autoriza:</td>
        <td width="180px" style="border-bottom: <?php echo $b; ?>" >&nbsp;<?php  echo $orden->getUsuarioConfirmo(); ?></td>
        <td  width="2px"></td>
        <td width="70px" class="titulo">&nbsp;Fecha:</td>
        <td  width="90px"  style="border-bottom: <?php echo $b; ?>" >&nbsp;<?php echo $orden->getFechaConfirmo(); ?></td>
        <td  width="2px"></td>
    </tr>
 
 
</table>