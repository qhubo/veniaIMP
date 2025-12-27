
<br><br><br><br>
<table style="width:744px;">

    <tr>
        <td  colspan="3" style="width:500px; font-size: 55px; font-weight: bold; text-align: center"><?php echo $registro->getCodigo(); ?></td>
    </tr>
     <tr>
        <td style="width:500px; font-size: 50px; font-weight: bold; text-align: center"><?php echo $registro->getFechaConfirmo('d/m/Y H:i:s'); ?></td>
    </tr>
    <tr>
        <td colspan="3"><br></td>
    </tr>
    
    <tr >
        <td style="width:100px;" > </td>
        <td style="  height: 25px; font-size: 44px; font-weight: bold;width:200px;">USUARIO </td>
        <td style="width:350px;"><?php echo $registro->getCreatedBy(); ?></td>
    </tr>    

    <tr>
        <td style="width:100px;"> </td>
        <td style="height: 25px;font-size: 44px; font-weight: bold;width:200px;">TIENDA </td>
         <td style="width:350px;"><?php echo $registro->getTienda()->getNombre(); ?></td>
    </tr>  
    <tr>
        <td style="width:100px;"> </td>
        <td style="height: 25px;font-size: 44px; font-weight: bold;width:200px;">VALOR DEL DEPÓSITO</td>
       <td style="width:150px; align-content:right; text-align: right;">Q <?php echo Parametro::formato($registro->getTotal(),false); ?></td>
    </tr>  
      <tr>
        <td style="width:100px;"> </td>
        <td style="height: 25px;font-size: 44px; font-weight: bold;width:200px;">FECHA DEL DEPÓSITO</td>
             <td style="width:350px;"><?php echo $registro->getFechaDeposito('d/m/Y'); ?></td>
    </tr>  
    <tr>
        <td style="width:100px;"> </td>
        <td style="height: 25px;font-size: 44px; font-weight: bold;width:200px;">BANCO</td>
         <td style="width:350px;"><?php echo $registro->getBanco()->getNombre(); ?></td>
    </tr>  
    <tr>
        <td style="width:100px;"> </td>
        <td style="height: 25px;font-size: 44px; font-weight: bold;width:200px;">BOLETA</td>
             <td style="width:350px;"><?php echo $registro->getBoleta(); ?></td>
    </tr>  
    <tr>
        <td style="width:100px;"> </td>
        <td style="height: 25px;font-size: 44px; font-weight: bold;width:200px;">CLIENTE</td>
       <td style="width:350px;"><?php echo $registro->getCliente(); ?></td>
    </tr>  
    <tr>
        <td style="width:100px;"> </td>
        <td style="height: 25px;font-size: 44px; font-weight: bold;width:200px;">TELEFONO</td>
            <td style="width:350px;"><?php echo $registro->getTelefono(); ?></td>
    </tr>  
    <tr>
        <td style="width:100px;"> </td>
        <td style="height: 25px;font-size: 44px; font-weight: bold;width:200px;">NUMERO DE PARTE</td>
           <td><?php echo $registro->getPieza(); ?></td>
    </tr>  
    <tr>
        <td style="width:100px;"> </td>
        <td style="height: 25px;font-size: 44px; font-weight: bold;width:200px;">STOCK</td>
         <td><?php echo $registro->getStock(); ?></td>
    </tr>  
    <tr>
        <td style="width:100px;"> </td>
        <td style="height: 25px;font-size: 44px; font-weight: bold;width:200px;">VENDEDOR</td>
         <td><?php echo $registro->getVendedor(); ?></td>
    </tr>  
    <tr>
        <td style="width:100px;"> </td>
        <td style="height: 25px;font-size: 44px; font-weight: bold;width:200px;">AUTORIZA</td>
         <td><?php echo $registro->getUsuarioConfirmo(); ?></td>
    </tr>  

    <tr>
        <td style="width:100px;"> </td>
        <td style="height: 25px;font-size: 44px; font-weight: bold;width:200px;">CONFIRMACION</td>
            <td><?php echo $registro->getDocumentoConfirmacion(); ?></td>
    </tr>  

</table>