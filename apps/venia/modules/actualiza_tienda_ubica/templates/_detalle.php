

<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-sort-down kt-font-info"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-success"> Resultado
                <?php if ($muestrabusqueda) { ?>  <small>&nbsp; puedes descargar el ARCHIVO MODELO segun la busqueda realizada, para importar una carga &nbsp;&nbsp;</small>                        <?php } ?>

            </h3>
        </div>
        <?php //if ($muestrabusqueda) { ?>
        <?php //if (count($productos) > 0) { ?>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/reporte') ?>" class="btn btn-dark" > <li class="fa fa-cloud-upload"></li> Archivo Modelo Carga  </a>
        </div>
        <?php //} ?>
        <?php //} ?>
    </div>
    <div class="kt-portlet__body">
        <div class="table-scrollable">
            <?php echo $forma->renderFormTag(url_for($modulo . '/muestra?pere=' . $pere), array('class' => 'form-horizontal"')) ?>
            <?php echo $forma->renderHiddenFields() ?>
            <table class="table-bordered table-checkable xdataTable no-footer xkt-datatable" xid="html_table" width="100%">
                <thead class="flip-content">
                    <tr class="active">          
                        <th  align="center"> Código Sku</th>
                        <th  align="center"> Nombre</th>

                        <th  align="center">Existencia Actual</th>
                        <th>Nueva Existencia</th>
                        <th width="200px">Ubicación</th>
<!--                        <th></th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php $PROCESA_PRODUCTOS =NULL; ?>
                    <?php $totalitem = 0 ?>
                    <?php if ($muestrabusqueda) { ?>
                        <?php foreach ($productos as $lista) { ?>
                            <tr>
                                <td><strong> <?php echo $lista->getCodigoSku() ?></strong> </td>
                                <td><?php echo $lista->getNombre() ?> </td>
                                <td align="right"><?php echo $lista->getExistencia(); ?></td>
                                <td width="150px">
                                    <?php $PROCESA_PRODUCTOS["_".$lista->getId()]=$lista->getId(); ?>
                                    <input class="form-control input-circle" placeholder="0" type="number" name="registro[numero_<?php echo $lista->getId() ?>]" id="registro_numero_<?php echo $lista->getId() ?>"  onkeypress='validate<?php echo $lista->getId() ?>(event)' >
                                </td> 
                                <td align="right">
                                    <input class="form-control input-circle" placeholder="" type="text"  name="registro[ubica_<?php echo $lista->getId() ?>]" id="registro_ubica_<?php echo $lista->getId() ?>"  xxxonkeypress='validate<?php echo $lista->getId() ?>(event)' >

                                </td>

                            </tr>
                        <?php } ?>
                    <?php } ?>
                    <?php if (!$muestrabusqueda) { ?>   
                        <?php if ($linea) { ?>
                            <?php foreach ($linea as $key => $nivel) { ?>
                            <?php $CanUbica=0; ?>
                            <?php foreach($nivel as $lista) { ?>
                                <?php $totalitem = $totalitem + $lista['Cantidad']; ?> 
                                <?php $productoId = $lista['productoId']; ?>
                                <tr <?php if ($lista['valido'] == 0) { ?>  class="danger" <?php } ?>  >
                                    <?php if ($lista['valido']) { ?>
                                        <td><?php echo $lista['Codigo'] ?> </td>
                                        <td><?php echo $lista['nombre'] ?></td>
                                    <?php } ?>
                                    <?php if (!$lista['valido']) { ?>
                                        <td></td>
                                        <td><strong>Código de producto no valido </strong></td>
                                    <?php } ?>
                                    <td align="right">
                                        <?php if ($lista['valido']) { ?>
                                            <?php echo $lista['existencia'] ?>
                                        <?php } ?>
                                    </td>
                                    <td width="150px">
                                        <?php if ($lista['valido']) { ?>
                                        <?php if ($CanUbica >0) { ?>
                                        <?php $PROCESA_PRODUCTOS["_".$productoId."_".$CanUbica]=$productoId; ?>
                                            <input class="form-control " placeholder="0" value="<?php echo $lista['Cantidad'] ?>" type="number" name="registro[numero_<?php echo $productoId ?>_<?php echo $CanUbica; ?>]" id="registro_numero_<?php echo $productoId ?>_<?php echo $CanUbica; ?>"  >
                                      <?php }  else { ?>
                                            <?php $PROCESA_PRODUCTOS["_".$productoId]=$productoId; ?>
                                            <input class="form-control " placeholder="0" value="<?php echo $lista['Cantidad'] ?>" type="number" name="registro[numero_<?php echo $productoId ?>]" id="registro_numero_<?php echo $productoId ?>"  onkeypress='validate<?php echo $productoId ?>(event)' >
                                        <?php } ?>  
                                                <?php } ?>  
                                    </td>    
                                    <td align="right"> 
                                        <?php if ($lista['valido']) { ?>
                                                             <?php if ($CanUbica >0) { ?>
                                 <input class="form-control" placeholder="" value="<?php echo $lista['ubicacion'] ?>"  name="registro[ubica_<?php echo $productoId ?>_<?php echo $CanUbica; ?>]" id="registro_ubica_<?php echo $productoId ?>_<?php echo $CanUbica; ?>""   >
                              
                                                             <?php } else { ?> 
                                            <input class="form-control" placeholder="" value="<?php echo $lista['ubicacion'] ?>"  name="registro[ubica_<?php echo $productoId ?>]" id="registro_ubica_<?php echo $productoId ?>"  >
                                        <?php } ?>  
                                            <?php } ?>  
                                    </td>
                                    <?php if ($lista['valido']) { ?>
                                <input type="hidden" readonly=""  value="<?php echo $lista['Cantidad'] ?>" id="res_<?php echo $productoId ?>" name="res_<?php echo $productoId ?>" >
                <!--                                            <div id="total_<?php echo $productoId ?>"> <?php echo $lista['existencia'] + $lista['Cantidad'] ?></div></td>-->
                            <?php } ?>  

                            </tr>
    <?php $CanUbica++; ?>                        
     <?php } ?>
                        
                        <?php } ?>
                    <?php } ?>                                
                <?php } ?>
                </tbody>
            </table>
<?php sfContext::getInstance()->getUser()->setAttribute('valores', serialize($PROCESA_PRODUCTOS), 'procesa_productos'); ?>

            <?php if ($bodega) { ?>
                <div class="row" style="padding-bottom:5px;">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-2">Tipo de Carga</div>
                    <div class="col-lg-3"> <?php echo $forma['tipo_carga'] ?>   </div>
                </div>                        
                <div class="row">
                    <div class="col-lg-6">
                        Confirmar Actualizacion de inventarios 
                    </div>
                    <div class="col-lg-2">Items  <input type="hidden"   value="<?php echo $estadob ?>"  name="estado" id="estado" >  </div>
                    <div class="col-lg-1"> <input class="form-control " readonly="true"  type="text" id="res_total" name="res_2111total" value="<?php echo $totalitem ?>" ></div>
                    <div class="col-lg-2">
                       <!--                                    <div id="procesar" name="procesar" <?php if ($estadob == 0) { ?>  style="display:none;" <?php } ?>>-->
                        <?php //if ($bodegaId) {  ?>
                        <button class="btn btn-primary btn-block  btn-block"
                                procesa="procesa"
                                type="submit">
                            <i class="fa fa-check "></i>
                            <span>Procesar</span>
                        </button>
                        <?php //}  ?>
                        <!--                                    </div>-->
                    </div>
                </div>
            <?php } ?>

            <?php echo '</form>'; ?>              
        </div>
    </div>
</div>
