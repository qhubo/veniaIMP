<table style="border-left-color:#0e90d2;  border-left-width:1px;   border-bottom-color:#0e90d2;  border-bottom-width:1px;  border-top-color:#0e90d2;  border-top-width:1px; border-right-color:#0e90d2;  border-right-width:1px"  width="680px" >
    <tr width="680px" >
        <td  style="background-color:#9e9e9e; text-align: center; color: white  " width="720px" >
            <font size="+3">   COMBO PRODUCTO </font>
    </td>
    </tr>
</table>
<br>
<table style="border-left-color:#0e90d2;  border-left-width:1px;   border-bottom-color:#0e90d2;  border-bottom-width:1px;  border-top-color:#0e90d2;  border-top-width:1px; border-right-color:#0e90d2;  border-right-width:1px"  width="720px" >
    <tr width="720px" >
        <td width="150px">
            <br>      <br>
            <?php if ($receta->getImagen()) { ?>
            <img src="<?php echo $receta->getImagen(); ?>" width="150px" >
            <?php }  else { ?>
            <br><br><br><br><br>       
     <?php } ?>
        </td>
        <td width="570px">
            <br> <br><br>
            <table width="570px" >
                <tr width="570px" >
                    <td width="70px"><h3>NOMBRE</h3></td>
                    <td width="285px"><font size="+2"><?php echo $receta->getNombre(); ?></font></td>
                        <td width="85px"><h3>Precio</h3></td>
                    <td width="200px"><font size="+2"><?php echo number_format($receta->getPrecio(), 2); ?> </font></td>
                                  </tr>
                      <tr width="570px" >
                          <td colspan="4" width="570px"><br></td>
                </tr>
                <tr width="570px" >
                <td width="75px"><h3>Código</h3></td>
                    <td width="200px"><font size="+1"><?php echo $receta->getCodigoSku(); ?></font></td>
  
                    
                    <td width="185px"><h3>Precio Variable</h3></td>
                    <td width="100px"><?php if ($receta->getPrecioVariable()) { echo "SI"; } else { echo "NO"; }  ?></td>
                </tr>
            </table></td>  
    </tr>
</table>

<br>
<table width="740px" style="border-left-color:#0e90d2;  border-left-width:1px;   border-bottom-color:#0e90d2;  border-bottom-width:1px;  border-top-color:#0e90d2;  border-top-width:1px; border-right-color:#0e90d2;  border-right-width:1px" >
    <tr>
    <td width="30px"></td>
    <td width="630px">
        <table width="630"  cellspacing="0" cellspadding="6" >
            <tr>
                <td width="250px"  style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Producto</strong></td>  
                <td width="370px"  colspan="2" style="text-align: center" ><strong>Opciones</strong></td>  
            </tr>
            <?php foreach ($detalle as $regi) { ?>
        <?php $combolista = ListaComboDetalleQuery::create()
                ->filterByProductoId($regi->getProductoDefault(), Criteria::NOT_EQUAL)
                ->filterByComboProductoDetalleId($regi->getId())->find(); ?>
            <tr>
                <td  width="250px" style="border-bottom-width: 1px">
                   <?php if ($receta->getPrecioVariable()) { ?> 
                    <strong> <?php echo number_format($regi->getPrecio(),2); ?>&nbsp;&nbsp;&nbsp;<br></strong>
                   <?php } ?>
                    <?php echo $regi->getProducto(); ?>
                
                    
                </td>
                <td  width="320px" style="border-bottom-width: 1px">  
                      <?php foreach ($combolista as $list) { ?>
                        <table   width="320px" >
                            <tr>
                                <td ><?php echo $list->getProducto()->getNombre(); ?></td>
                                <td  width="155px">
                                   <?php   echo number_format($list->getPrecio(),2); ?>
                                    <font size="-2">Precio&nbsp;Adicional</font>
                                </td>
                            </tr>
                        </table>
                    <?php } ?>  
                     </td>
                     <td   width="50px" style="text-align: right; border-bottom-width: 1px"><?php if ($regi->getObligatorio()) { ?><font size="+5"> *</font> <?php } ?> </td>
        
         
            </tr>
            <?php } ?>
        </table>
    </td>
    <td width="60px"></td>
    </tr>
    
    
       <tr>
    <td width="50px"><br></td>
    <td width="600px"><br></td>
    <td width="70px"><br></td>
    </tr>

</table>