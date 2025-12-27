<table class="table table-bordered  ">
    <tr>
        <th align="center" width="80px"><span class="kt-font-success">Nit </span></th>
        <td>        <h5><?php echo $orden->getNit() ?></h5>  </td>
        <th align="center" width="80px"><span class="kt-font-success">Crédito </span></th>
        <td>        <h5><?php echo $orden->getDiaCredito() ?> Días </h5>  </td>
    </tr>
    <tr>
        <th align="center"  width="80px"><span class="kt-font-success">Nombre </span></th>
        <td>        <h5><?php echo $orden->getNombre() ?></h5>  </td>
         <th align="center" width="80px"><span class="kt-font-success">Proveedor </span></th>
        <td>    <?php if ($orden->getProveedorId()) { ?>    <h5><?php echo $orden->getProveedor()->getCodigo(); ?>  </h5>  <?php } ?> </td>
    </tr> 
    
     <tr>
        <th align="center"  width="80px"><span class="kt-font-success">Observaciones </span></th>
        <td>        <?php echo $orden->getComentario() ?>  </td>
         <th align="center" width="80px"><span class="kt-font-success">Usuario </span></th>
        <td>    <?php echo $orden->getUsuario(); ?> </td>
    </tr>
</table>

<table class="table table-bordered  xdataTable table-condensed flip-content">
    <thead class="flip-content">
        <tr class="active">

            <th align="center"><span class="kt-font-success">Documento </span></th>
            <th align="center"><span class="kt-font-success">Fecha  Documento</span></th>
<!--            <th align="center"><span class="kt-font-success">Fecha  Contabilidad</span></th>-->
            <th align="center"><span class="kt-font-success">Sub Total</span></th>
            <th align="center"><span class="kt-font-success">Iva</span></th>
            <th align="center"><span class="kt-font-success">Total</span></th>

        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $orden->getSerie() ?> <?php echo $orden->getNoDocumento() ?> </td>
            <td><?php echo $orden->getFechaDocumento('d/m/Y') ?></td>
<!--            <td><?php echo $orden->getFechaContabilizacion('d/m/Y') ?></td>-->
            <td style ="text-align: right; align-content: right" ><?php echo number_format($orden->getSubTotal(), 2); ?> </td>
            <td style ="text-align: right; align-content: right"><?php echo number_format($orden->getIva(), 2); ?> </td>
            <td style="text-align: right"><h3><?php echo number_format($orden->getValorTotal(), 2); ?></h3> </td>
        </tr>
        
        <?php if ($orden->getValorImpuesto()) { ?>
                 <tr>
                       <td  ></td>
                <td><?php //echo $can;  ?></td>
                <td>ISR</td>
                <td>Valor Retenido</td>
           
                <td> <div style="text-align: right"> <?php echo Parametro::formato($orden->getValorImpuesto() * -1); //, 2, '.', '');  ?></div> </td>
          
            </tr>
                 <tr>
                       <td  ></td>
                <td><?php //echo $can;  ?></td>
                <td colspan="2" style="text-align: right"><strong> <font size="+2">VALOR PAGAR</font></strong> </td>

                <td> <div style="text-align: right"><strong> <font size="+2"> <?php echo Parametro::formato($orden->getValorTotal()+$orden->getValorImpuesto() * -1); //, 2, '.', '');  ?></font></strong></div> </td>
          
            </tr>
        
        <?php } ?>
        
        
    </tbody>

</table>


