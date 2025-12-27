<?php $pere = 0; ?>      
<?php foreach ($productos as $lista) { ?>
    <?php if ($lista->getTercero()) { ?> <?php $pere++; ?>
    <?php } ?>
<?php } ?>

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
        <?php if ($muestrabusqueda) { ?>
            <?php if (count($productos) > 0) { ?>
                <div class="kt-portlet__head-toolbar">
                    <a href="<?php echo url_for($modulo . '/reporte') ?>" class="btn btn-dark" > <li class="fa fa-cloud-upload"></li> Archivo Modelo Carga  </a>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="kt-portlet__body">
        <div class="table-scrollable">
            <?php echo $forma->renderFormTag(url_for($modulo . '/muestra?pere=' . $pere), array('class' => 'form-horizontal"')) ?>
            <?php echo $forma->renderHiddenFields() ?>
<!--            <div class="row">
                <div class="col-lg-10">  </div>
                <div class="col-lg-2">				
                    <div class="kt-input-icon kt-input-icon--left">
                        <input type="text" class="form-control" placeholder="Buscar ..." id="generalSearch">
                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                            <span><i class="la la-search"></i></span>
                        </span>
                    </div>
                </div>
            </div>-->
            <table class="table-bordered table-checkable xdataTable no-footer xkt-datatable" xid="html_table" width="100%">

                <thead class="flip-content">
                    <tr class="active">          
                        <th  align="center"> Código Sku</th>
                        <th  align="center"> Nombre</th>
                        <th  align="center">Descripción </th>

                        <th  align="center">Existencia
                            <?php if ($bodega) { ?>
                                <?php echo $bodega->getCodigo(); ?>
                            <?php } ?>
                        </th>
                        <th>Ingreso</th>
                        <?php if ($pere > 0) { ?>
                            <td>Vence</td> 
                        <?php } ?>

                        <th width="200px">Total</th>
<!--                        <th></th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php $totalitem = 0 ?>
                    <?php if ($muestrabusqueda) { ?>
                        <?php $perec = 0; ?> 
                        <?php foreach ($productos as $lista) { ?>
                    
                            <tr  <?php if ($lista->getTercero()) { ?> <?php $perec++; ?>
                                    style="background-color:#dbeddc !important;"
                                <?php } ?> >
                                <td><strong> <?php echo $lista->getCodigoSku() ?></strong> </td>
                                <td><?php echo $lista->getNombre() ?>
             
                                </td>
                                <td>
                                    <font size="-1"> <?php echo $lista->getTipoAparato(); ?></font>   
                                </td>
                                <td align="right"><?php echo $lista->getExistenciaBodega($bodegaId); ?></td>
                                <td width="150px">
                                    <input class="form-control input-circle" placeholder="0" type="number" name="registro[numero_<?php echo $lista->getId() ?>]" id="registro_numero_<?php echo $lista->getId() ?>"  onkeypress='validate<?php echo $lista->getId() ?>(event)' >
                                </td> 
                                <?php if ($pere > 0) { ?>
                                    <td>
                                        <?php if ($lista->getTercero()) { ?> 
                                            <?php echo $forma['fechaInicio_' . $lista->getId()]; ?>
                                        <?php } ?>
                                    </td> 
                                <?php } ?>
                                <td align="right">

                                    <div id="total_<?php echo $lista->getId() ?>"> <?php echo $lista->getExistenciaBodega($bodegaId) ?></div></td>
<!--                                <td>           <?php echo "registro[numero_" . $lista->getId() . "]"; ?></td>-->
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    <?php if (!$muestrabusqueda) { ?>   
                        <?php if ($linea) { ?>
                            <?php foreach ($linea as $lista) { ?>
                                <?php $totalitem = $totalitem + $lista['Cantidad']; ?> 
                                <?php $productoId = $lista['productoId']; ?>
                                <tr  <?php if ($lista['tercero']) { ?> <?php $perec++; ?>
                                        style="background-color:#dbeddc !important;"
                                    <?php } ?>

                                    <?php if ($lista['valido'] == 0) { ?> 
                                        class="danger"
                                    <?php } ?>  >

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
                                            <?php echo $lista['existencia'] ?>
                                        <?php } ?>
                                    </td>
                                    <td width="150px">
                                        <?php if ($lista['valido']) { ?>
                                            <input class="form-control input-circle" placeholder="0" value="<?php echo $lista['Cantidad'] ?>" type="number" name="registro[numero_<?php echo $productoId ?>]" id="registro_numero_<?php echo $productoId ?>"  onkeypress='validate<?php echo $productoId ?>(event)' >
                                        <?php } ?>  
                                    </td>    
                                    <?php if ($lista['valido']) { ?>
                                        <td>

                                            <?php if ($lista['tercero']) { ?>
                                                <input class="form-control" data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"  name="registro[fechaInicio_<?php echo $productoId; ?>]" id="registro_fechaInicio_<?php echo $productoId; ?>"   value=" <?php echo $lista['fecha'] ?>" >
                                            <?php } ?>
                                        </td>

                                    <?php } ?>
                                    <td align="right">
                                        <?php if ($lista['valido']) { ?>
                                            <input type="hidden" readonly=""  value="<?php echo $lista['Cantidad'] ?>" id="res_<?php echo $productoId ?>" name="res_<?php echo $productoId ?>" >
                                            <div id="total_<?php echo $productoId ?>"> <?php echo $lista['existencia'] + $lista['Cantidad'] ?></div></td>
                                    <?php } ?>  
<!--                                    <td><?php echo $productoId; ?></td>-->
                                </tr>
                            <?php } ?>
                        <?php } ?>                                
                    <?php } ?>
                </tbody>
                <tfoot>




                </tfoot>
            </table>


            <?php if ($bodega) { ?>
                               

                        
            <div class="row" style="padding-bottom:5px; padding-top:15px;">
             <div class="col-lg-2"></div>
                      <div class="col-lg-1">Observaciones&nbsp;<font color="red" size="+2">*</font> </div>
                       <div class="col-lg-3"> <?php echo $forma['observaciones'] ?>   </div>
             <div class="col-lg-1">No Orden</div>
                       <div class="col-lg-2"> <?php echo $forma['numero_orden'] ?>   </div>
         

         </div>

   <div class="row" style="padding-bottom:5px; ">
             <div class="col-lg-2"></div>
                      <div class="col-lg-1">Fecha&nbsp;<font color="red" size="+2">*</font> </div>
                       <div class="col-lg-2   <?php if ($forma['fechaDocumento']->hasError()) echo "has-error" ?>">
        <font size ="-1">  </font>
        <?php echo $forma['fechaDocumento'] ?>          
        <span class="help-block form-error"> 
            <?php echo $forma['fechaDocumento']->renderError() ?>       
        </span>
   </div>
                      
                      
                      <div class="col-lg-1">Documento&nbsp;<font color="red" size="+2">*</font> </div>
                     
                      <div class="col-lg-2   <?php if ($forma['numero_documento']->hasError()) echo "has-error" ?>">
   
        <?php echo $forma['numero_documento'] ?>          
        <span class="help-block form-error"> 
            <?php echo $forma['numero_documento']->renderError() ?>       
        </span>
 

         </div>
   </div>
                     
  <div class="row" style="padding-bottom:5px; ">
     <div class="col-lg-4"></div>
                      <div class="col-lg-2">Tipo de Carga</div>
                       <div class="col-lg-3"> <?php echo $forma['tipo_carga'] ?>   </div>
         

         </div>     

                        
                <div class="row">
                    <div class="col-lg-6">
                        Confirmar Ingreso <strong>Tienda</strong>    <?php echo $bodega->getNombre(); ?>     
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
