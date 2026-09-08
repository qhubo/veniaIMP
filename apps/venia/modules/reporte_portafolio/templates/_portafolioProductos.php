<style>

body {
    font-family: dejavusans;
    font-size: 32px;
    color: #000;
}

.titulo {
    font-size: 40px;
    font-weight: bold;
}

.subtitulo {
    font-size: 26px;
}

.producto {
    border: 1px solid #CCCCCC;
    padding: 6px;
}

.imagen {
    text-align: center;
}

.nombre {
    font-size: 30px;
    font-weight: bold;
}

.sku {
    font-size: 22px;
    color: #666666;
}

.marca {
    font-size: 25px;
}

.compatibilidad {
    font-size: 22px;
}

.existencia {
    font-size: 18px;
    font-weight: bold;
}

.precio {
    font-size: 30px;
    font-weight: bold;
}

.marca-vehiculo {
    background-color: #146EBE;
    color: #FFFFFF;
    padding: 2px;
    font-size: 14px;
}

.separador {
    height: 8px;
}

</style>
<table width="100%" cellpadding="3">
    <tr>
        <td width="20%">  </td>
        <td width="60%" align="center">
            <span class="titulo">
                PORTAFOLIO DE PRODUCTOS
            </span>
           <br>
            <span class="subtitulo"> <?php   echo $empresa ? $empresa->getNombre() : '';   ?>  </span>
            <br>
            <span class="subtitulo">    Fecha:   <?php echo date('d/m/Y'); ?>  </span>
        </td>
        <td width="20%">
        </td>
    </tr>
</table>
<br>
<?php $contador = 0; ?>
<table width="100%" cellpadding="5" cellspacing="5" >
<?php foreach ($productos as $producto) { ?>
    <?php  $productoId = $producto->getId();
    $existencia = isset( $existencias[$productoId]) ? $existencias[$productoId]: 0;
    $marcas = isset($marcasVehiculo[$productoId])? $marcasVehiculo[$productoId]: array();
    $contador++;
    ?>
    <?php if (($contador - 1) % 2 == 0) { ?>
        <tr>
    <?php } ?>
        <td width="50%" valign="top" >
            <table  width="100%"  cellpadding="4" class="producto" >
                <tr>
                   <td width="38%" valign="middle" align="center"  >
                        <?php if ($producto->getImagen() != '') { ?>
                            <img src="<?php  echo $producto->getImagen();  ?>" width="120" >
                        <?php } ?>
                    </td>
                    <td width="62%" valign="top"  >
                       <div class="sku">
                            SKU:  <?php  echo $producto->getCodigoSku();   ?>
                        </div>
                        <div class="nombre">
                            <?php  echo $producto->getNombre();  ?>
                        </div>
                        <?php  if ( $producto->getNombreIngles() != '') { ?>
                            <div class="sku">
                                <?php  echo $producto->getNombreIngles(); ?>
                            </div>
                        <?php } ?>
                        <br>
                       <div class="marca">
                            <strong> Marca: </strong>
                            <?php  echo $producto->getMarcaProducto(); ?>
                        </div>
                        <?php if ($producto->getOrigen() != '') { ?>
                            <div class="marca">
                                <strong> Origen: </strong>
                                <?php  echo $producto->getOrigen();  ?>
                            </div>
                        <?php } ?>
                        <?php if (!empty($marcas)) { ?>
                            <br>
                            <div class="compatibilidad">
                                <strong> Compatible con:  </strong>
                            </div>
                            <div>
                                <?php  foreach ($marcas as $marcaVehiculo) {  ?>
                                    <span class="marca-vehiculo">
                                        <?php  echo htmlspecialchars($marcaVehiculo);   ?>
                                    </span>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <br>
                        <div class="existencia">   Existencia:
                            <?php echo number_format($existencia, 0,'.', ',' ); ?>
                        </div>
                        <div class="precio">
                            <?php  echo Parametro::formato( $producto->getPrecio(),  true);  ?>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    <?php if ($contador % 2 == 0) { ?>
        </tr>
        <tr>
            <td colspan="2" height="5" >  </td>
        </tr>
    <?php } ?>
<?php } ?>
<?php if ($contador % 2 != 0) { ?>
        <td width="50%"></td>
        </tr>
<?php } ?>
</table>