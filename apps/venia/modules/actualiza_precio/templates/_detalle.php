<?php $tex='Precio'; ?>
<?php if ($em==2)  { ?>
<?php $tex='Costo'; ?>
<?php } ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-sort-down kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-danger"> Resultado
                <?php if ($muestrabusqueda) { ?>  <small>&nbsp; puedes descargar el ARCHIVO MODELO segun la busqueda realizada, para importar una carga &nbsp;&nbsp;</small>                        <?php } ?>

            </h3>
        </div>
        <?php //if ($muestrabusqueda) { ?>
        <?php //if (count($productos) > 0) { ?>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for('actualiza_inventario_ubica/reporteF') ?>" class="btn btn-dark" > <li class="fa fa-cloud-upload"></li> Archivo Modelo Carga  </a>
        </div>
        <?php //} ?>
        <?php //} ?>
    </div>
    <div class="kt-portlet__body">
        <div class="table-scrollable">
            <?php echo $forma->renderFormTag(url_for($modulo . '/muestra'), array('class' => 'form-horizontal"')) ?>
            <?php echo $forma->renderHiddenFields() ?>
            <table class="table table-bordered  dataTable table-condensed flip-content" >
                <thead class="flip-content">
                    <tr class="active">          
                        <th  align="center"><div  style="font-weight:bold !important;"> Código Sku </div> </th>
                        <th  align="center"><div  style="font-weight:bold !important;">  Nombre </div></th>
                        <th  align="center"><div  style="font-weight:bold !important;"> Descripción</div> </th>
                        <th  align="center"><div  style="font-weight:bold !important;"> <?Php echo $tex; ?> Actual</div> </th>
                        <th><div  style="font-weight:bold !important;"> Nuevo <?Php echo $tex; ?></div> </th>
                        <th width="150px"><font size="-2"> Ult. Actualización </font></th>
                    </tr>
                </thead>
                <?php  $prefijo = substr($em, 0,2); ?>

                <tbody>
                    <?php $totalitem = 0 ?>
                    <?php if ($muestrabusqueda) { ?>
                        <?php foreach ($productos as $lista) { ?>
                    
                    <?php $valor =$lista->getPrecio(); ?>
                    <?php $fechaUpd =html_entity_decode($lista->getFechaPrecio($em)) ; ?>
                    <?php if ($tex=='Costo') { ?>
                    <?php $valor =$lista->getCostoProveedor(); ?>
                     <?php //$fechaUpd ="" ; ?>
                    <?php } ?>
                    <?php if ($prefijo =='LP') { ?>
                    <?php  $listaPrecioId = str_replace($prefijo, "", $em); ?>
                     <?php $valor =0 ?>
                    <?php 
                     $precionew= ProductoPrecioQuery::create()
                                    ->filterByListaPrecioId($listaPrecioId)
                                    ->filterByProductoId($lista->getId())
                                    ->findOne();
                     
                    ?>
                    <?php if ($precionew)  { ?>
                    <?php $valor =$precionew->getValor(); ?>
                    <?php } ?>
                    
                      <?php } ?>
                    <tr>
                                <td><?php echo $lista->getCodigoSku() ?> </td>
                                <td><?php echo $lista->getNombre() ?><br><?php echo substr($lista->getDescripcion(), 0, 100) ?></td>
                                <td><font size="-1"> <?php echo $lista->getTipoAparato(); ?></font> </td>
                                <td align="right"><?php echo Parametro::formato($valor,false); ?></td>
                                <td width="150px">
                                    <input class="form-control input-circle"   name="registro[numero_<?php echo $lista->getId() ?>]" id="registro_numero_<?php echo $lista->getId() ?>"  onkeypress='validate<?php echo $lista->getId() ?>(event)' >
                                </td>    
                                <td align="center">
                                    <font size="-2">  <?php echo $fechaUpd ?> </font>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    <?php if (!$muestrabusqueda) { ?>   
                        <?php if ($linea) { ?>
                            <?php foreach ($linea as $lista) { ?>
                                <?php $totalitem = $totalitem + $lista['Cantidad']; ?> 
                                <?php $productoId = $lista['productoId']; ?>
                                <tr class="<?php if ($lista['valido'] == 0) { ?> danger <?php } ?>" >
                                    <td><?php echo $lista['Codigo'] ?> </td>
                                    <?php if ($lista['valido']) { ?>
                                        <td><?php echo $lista['nombre'] ?></td>
                                        <td><?php echo $lista['descripcion'] ?></td>
                                    <?php } ?>
                                    <?php if (!$lista['valido']) { ?>
                                        <td></td>
                                        <td><strong>Código de producto no valido </strong></td>
                                    <?php } ?>
                                    <td align="right">
                                        <?php if ($lista['valido']) { ?>
                                            <?php echo $lista['anterior'] ?>
                                        <?php } ?>
                                    </td>
                                 
                                    <td width="150px">
                                        <?php if ($lista['valido']) { ?>
                                            <input class="form-control input-circle" value="<?php echo $lista['Cantidad'] ?>" type="number" name="registro[numero_<?php echo $productoId ?>]" id="registro_numero_<?php echo $productoId ?>"  onkeypress='validate<?php echo $productoId ?>(event)' >
                                        <?php } ?>  
                                    </td>    
                                    <td align="center">
                                        <?php echo html_entity_decode($lista['fecha']) ?>
                                    </td> 
                                </tr>
                            <?php } ?>
                        <?php } ?>                                
                    <?php } ?>
                </tbody>
                <tfoot>
<!--                    <tr>
                        <td colspan="2"></td>
                        <td colspan="3" style="visibility: hidden;" > <?php echo $forma['tipo_carga'] ?>   </td>
                        <td colspan="1"> </td>

                    </tr>-->
                    <tr>
                        <?php $estadob = 0 ?>
                        <?php
                        if ($totalitem > 0) {
                            $estadob = 1;
                        }
                        ?>
                        <td colspan="3" align="right"><span class="kt-font-info bold uppercase"> Confirmar Actualizacion de precios 
                            </span></td>
                        <td>   </td>
                        <td> <input class="form-control " readonly="true"  type="hidden" id="res_totalxx" name="res_2111total" value="<?php //echo $totalitem  ?>" ></td>
                        <td colspan="1">
                            <button class="btn btn-primary btn-block  btn-block"
                                    procesa="procesa"
                                    type="submit">
                                <i class="fa fa-check "></i>
                                <span>Procesar</span>
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <?php echo '</form>'; ?>              
        </div>
    </div>
</div>
