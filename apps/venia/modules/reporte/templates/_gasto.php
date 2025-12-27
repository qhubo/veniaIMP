<table  width="740px">
    <tr>
        <td  width="10px"> </td>
        <td>
            <table cellpadding="2" >
                <tr >
                    <th   align="left" width="100px">&nbsp;Proyecto </th>
                    <td  style="border: 0.2px solid #5E80B4;"width="345px">        <?php echo $orden->getProyecto() ?>  </td>
                    <td width="10px">&nbsp;</td>
                    <th  align="left" width="100px">&nbsp;Crédito </th>
                    <td  style="border: 0.2px solid #5E80B4;"width="170px">        <?php echo $orden->getDiasCredito() ?> Días   </td>
                </tr>
                <tr>
                    <th  lign="left"  width="100px">&nbsp;Tienda </th>
                    <td  style="border: 0.2px solid #5E80B4;"width="345px">        <?php echo $orden->getTienda() ?> </td>
                    <td width="10px">&nbsp;</td>
                    <th  align="left" width="100px">&nbsp;Proveedor </th>
                    <td   style="border: 0.2px solid #5E80B4;" width="170px">    <?php if ($orden->getProveedorId()) { ?>   <?php echo $orden->getProveedor()->getCodigo(); ?>    <?php } ?> </td>
                </tr> 

                <tr>
                    <th  align="left"  width="100px">&nbsp;Observaciones </th>
                    <td style="border: 0.2px solid #5E80B4;font-size:25px;"width="345px">        <?php echo $orden->getObservaciones() ?>  </td>
                    <td width="10px">&nbsp;</td>
                    <th align="left" width="100px">&nbsp;Usuario </th>
                    <td style="border: 0.2px solid #5E80B4;" width="170px">    <?php echo $orden->getUsuario(); ?> </td>
                </tr>
            </table>

            <br>
            <br>
            <table cellpadding="2"  >
                <tr>

                    <th  style="border: 0.2px solid #5E80B4;"  align="center" width="200px">Fecha </th>
                    <th style="border: 0.2px solid #5E80B4;"  align="center" width="110px" >Tipo Documento</th>
                    <th style="border: 0.2px solid #5E80B4;"  align="center" width="110px">Documento</th>
                    <th style="border: 0.2px solid #5E80B4;" align="center" width="100px">Sub Total</th>
                    <th  style="border: 0.2px solid #5E80B4;" align="center" width="85px">Iva</th>
                    <th  style="border: 0.2px solid #5E80B4;" align="center" width="120px">Total</th>

                </tr>
                <tr>
                    <td style="border: 0.2px solid #5E80B4;"> <?php echo $orden->getFecha('d/m/Y') ?> </td>
                    <td style="border: 0.2px solid #5E80B4;" align="center"><?php echo $orden->getTipoDocumento() ?></td>
                    <td style="border: 0.2px solid #5E80B4;" align="center"><?php echo $orden->getDocumento() ?></td>
                    <td style="border: 0.2px solid #5E80B4;" align="right"><?php echo number_format($orden->getSubTotal(), 2); ?> </td>
                    <td style="border: 0.2px solid #5E80B4;" align="right" ><?php echo number_format($orden->getIva(), 2); ?> </td>
                    <td style="border: 0.2px solid #5E80B4;" align="right"><h3><?php echo number_format($orden->getValorTotal(), 2); ?></h3> </td>
                </tr>
            </table>
            <br>
            <br>
            <table cellpadding="2">
                <br><br>
                <tr >
                    <th  align="center" width="30px" style="font-size:30px; border-left: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4; text-align: center"># </th>
                    <th  align="center" width="325px"  style="font-size:30px; border-left: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4;text-align: center">Descripción </th>
                    <th  align="center" width="90px"  style="font-size:30px;border-left: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4; text-align: center">Cantidad </th>
                    <th  align="center" width="200px"  style="font-size:30px; border-left: 0.2px solid #5E80B4;border-top: 0.2px solid #5E80B4; text-align: center; border-right: 0.2px solid #5E80B4;">Valor Total </th>
                </tr>

                <?php $can = 0; ?>
                <?php foreach ($lista as $registro) { ?>
                    <?php $can++; ?>
                    <tr>
                        <td width="30px" style="font-size:25px;border-left: 0.2px solid #5E80B4;  "><?php echo $can; ?> </td>
                        <td width="325px" style="font-size:25px;border-left: 0.2px solid #5E80B4;">&nbsp;&nbsp;<?php echo $registro->getConcepto(); ?></td> 
                        <td width="90px"  style="text-align: right;font-size:25px;border-left: 0.2px solid #5E80B4;" ><?php echo $registro->getCantidad(); ?>&nbsp;&nbsp;</td> 
                        <td width="200px" style="text-align: right;font-size:25px;border-left: 0.2px solid #5E80B4; border-right: 0.2px solid #5E80B4;" ><?php echo Parametro::formato($registro->getValorTotal()); ?>&nbsp;&nbsp;</td>
            
                    </tr>
<?php } ?>
                    
             
                    <?php if ($orden->getValorImpuesto() > 0) { ?>
            <tr>
                <td width="30px" style="font-size:25px;border-left: 0.2px solid #5E80B4;"></td>
                <td  width="325px" style="font-size:25px;border-left: 0.2px solid #5E80B4;">ISR</td>
                <td width="90px"  style="text-align: right;font-size:25px;border-left: 0.2px solid #5E80B4;">Valor Retenido</td>
                <td width="200px" style="text-align: right;font-size:25px;border-left: 0.2px solid #5E80B4; border-right: 0.2px solid #5E80B4;">  <?php echo Parametro::formato($orden->getValorImpuesto() * -1);  ?> </td>
         
            </tr>
<?php } ?>
            
              <tr>
         
                <td colspan="3" width="445px"  style="font-size:25px;border-left: 0.2px solid #5E80B4;"  style="text-align: right"><font size="+2"> <strong> Valor  a Pagar </strong></font>  </td>
                <td width="200px" style="text-align: right;font-size:25px;border-left: 0.2px solid #5E80B4; border-right: 0.2px solid #5E80B4;"> <font size="+2"> <strong><?php echo Parametro::formato($orden->getValorTotal()- $orden->getValorImpuesto()); ?> </strong></font>  </td>
         
            </tr>
                    
                <tr>
                    <td style="border-top: 0.2px solid #5E80B4;"></td>
                    <td style="border-top: 0.2px solid #5E80B4;"></td>
                    <td style="border-top: 0.2px solid #5E80B4;"></td>
                    <td style="border-top: 0.2px solid #5E80B4;"></td>
                </tr>

            </table>

  <?Php $tipoDocumento = "Gasto"; ?>
 <?php include_partial('soporte/valorCampoReporte', array('tipoDocumento' => $tipoDocumento, 'idDoc' => $orden->getId())) ?> 
   

        </td>     
    </tr>
</table>

