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
    font-size: 27px;
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
.existencia-total {
    font-size: 20px;
    font-weight: bold;
    background-color: #EAF7F5;
    padding: 6px;
}
.filtros-aplicados {
    font-size: 16px;
}

.marca-vehiculo {
    background-color: #146EBE;
    color: #FFFFFF;
    padding: 2px;
    font-size: 28px;
}
.separador {
    height: 8px;
}

</style>

<?php $contador = 0; ?>
<div class="filtros-aplicados">
    <strong>Filtros aplicados:</strong>
    Marca producto: <?php echo $filtros['marcaProducto'] !== '' ? htmlspecialchars($filtros['marcaProducto'], ENT_QUOTES, 'UTF-8') : 'Todas'; ?>
    | Marca vehículo: <?php echo $filtros['marcaVehiculo'] !== '' ? htmlspecialchars($filtros['marcaVehiculo'], ENT_QUOTES, 'UTF-8') : 'Todas'; ?>
    | Búsqueda: <?php echo $filtros['buscar'] !== '' ? htmlspecialchars($filtros['buscar'], ENT_QUOTES, 'UTF-8') : 'Sin búsqueda'; ?>
</div>
<div class="existencia-total">Productos: <?php echo count($productos); ?> | Existencia total: <?php echo number_format($existenciaTotal, 0, '.', ','); ?></div>
<?php if (!$productos || count($productos) === 0) { ?>
    <div class="producto">No se encontraron productos con los filtros seleccionados.</div>
<?php } ?>
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
                        
                                                  <div>
                                <?php  foreach ($marcas as $marcaVehiculo) {  ?>
                                    <span class="marca-vehiculo">
                                        <?php  echo htmlspecialchars($marcaVehiculo);   ?>
                                    </span>
                                <?php } ?>
                                <?php if (count($marcas)==0 ) { ?>
                                <br>      <br>
                                <?php } ?>
                            </div>
                        <?php } ?>            
                  
                        <div class="precio">
                            <?php  echo  "$ ".Parametro::formato( $producto->getPrecio(),  true);  ?>
                        </div>
                        <div class="existencia">
                            Existencia total: <?php echo number_format($existencia, 0, '.', ','); ?>
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
