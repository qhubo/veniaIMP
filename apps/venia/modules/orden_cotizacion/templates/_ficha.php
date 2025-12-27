<table class="table table-bordered  ">
    <tr>
        <th align="center" width="80px"><span class="kt-font-success">Nit </span></th>
        <td>        <h5><?php echo $orden->getNit() ?></h5>  </td>
        <th align="center" width="80px"><span class="kt-font-success">Estatus </span></th>
        <td style="background-color: #146CB5; color: white" >  <?php echo $orden->getEstatus(); ?>        </td>
    </tr>
    <tr>
        <th align="center"  width="80px"><span class="kt-font-success">Nombre </span></th>
        <td>        <h5><?php echo $orden->getNombre() ?></h5>  </td>
         <th align="center" width="80px"><span class="kt-font-success">Cliente </span></th>
        <td>    <?php if ($orden->getClienteId()) { ?>    <h5><?php echo $orden->getCliente()->getCodigo(); ?>  </h5>  <?php } ?> </td>
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
            <th align="center"><span class="kt-font-success">Fecha  Vencimiento</span></th>
            <th align="center"><span class="kt-font-success">Sub Total</span></th>
            <th align="center"><span class="kt-font-success">Iva</span></th>
            <th align="center"><span class="kt-font-success">Total</span></th>

        </tr>
    </thead>
    <tbody>
        <tr>
            <td> </td>
            <td><?php echo $orden->getFechaDocumento('d/m/Y') ?></td>
            <td><?php echo $orden->getFechaVencimiento('d/m/Y') ?></td>
            <td><?php echo number_format($orden->getSubTotal(), 2); ?> </td>
            <td><?php echo number_format($orden->getIva(), 2); ?> </td>
            <td><h3><?php echo number_format($orden->getValorTotal(), 2); ?></h3> </td>
        </tr>
    </tbody>

</table>


