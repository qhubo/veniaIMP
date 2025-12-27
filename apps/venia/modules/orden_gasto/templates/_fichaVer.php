<table class="table table-bordered  ">
    <tr>
        <th align="center" width="80px"><span class="kt-font-success">Proyecto </span></th>
        <td>        <h5><?php echo $orden->getProyecto() ?></h5>  </td>
        <th align="center" width="80px"><span class="kt-font-success">Crédito </span></th>
        <td>        <h5><?php echo $orden->getDiasCredito() ?> Días </h5>  </td>
    </tr>
    <tr>
        <th align="center"  width="80px"><span class="kt-font-success">Tienda</span></th>
        <td>        <h5><?php echo $orden->getTienda() ?></h5>  </td>
         <th align="center" width="80px"><span class="kt-font-success">Proveedor </span></th>
        <td>    <?php if ($orden->getProveedorId()) { ?>    <h5><?php echo $orden->getProveedor()->getCodigo(); ?>  </h5>  <?php } ?> </td>
    </tr> 
    
     <tr>
        <th align="center"  width="80px"><span class="kt-font-success">Observaciones </span></th>
        <td>        <?php echo $orden->getObservaciones() ?>  </td>
         <th align="center" width="80px"><span class="kt-font-success">Usuario </span></th>
        <td>    <?php echo $orden->getUsuario(); ?> </td>
    </tr>
</table>

<table class="table table-bordered  xdataTable table-condensed flip-content">
    <thead class="flip-content">
        <tr class="active">
 <th align="center"><span class="kt-font-success">Fecha  </span></th>
            <th align="center"><span class="kt-font-success">Tipo Documento </span></th>
            <th align="center"><span class="kt-font-success">No  Documento</span></th>
           
     
            <th align="center"><span class="kt-font-success">Total</span></th>

        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $orden->getFecha('d/m/Y') ?></td>
               <td><?php echo $orden->getTipoDocumento() ?></td>
            <td> <?php echo $orden->getDocumento() ?> </td>
         

            <td><h3><?php echo number_format($orden->getValorTotal()-$orden->getValorImpuesto(), 2); ?></h3> </td>
        </tr>
    </tbody>

</table>


