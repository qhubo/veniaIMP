<?php $modulo = $sf_params->get('module'); ?>
<?php $empresaId = $usuario->getEmpresaId() ?>
<div class="kt-portlet kt-portlet--responsive-mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon-squares kt-font-success"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-brand">Vista Previa 
                <small> visualización de los productos nuevos a cargar  </small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="<?php echo url_for($modulo . '/index') ?>" class="btn btn-secondary btn-dark" > <i class="flaticon-reply"></i> Retornar </a>

        </div>
    </div>
    <div class="kt-portlet__body">


        <div class="table-scrollable">
            <table class="table table-bordered  xdataTable table-condensed flip-content" >
                <thead class="flip-content">
                    <tr class="active">
                        <th  align="center"><font size="-1"><?php echo strtoupper('codigo_sku') ?></font>  </th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('codigo_barras') ?></font></th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('codigo_arancel') ?></font></th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('codigo_grupo') ?> </font><?php //echo TipoAparatoQuery::tipo();      ?> </th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('grupo') ?></font><?php //echo TipoAparatoQuery::tipo();      ?> </th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('codigo_subgrupo') ?></font><?php //echo TipoAparatoQuery::marca();      ?></th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('subgrupo') ?> </font><?php //echo TipoAparatoQuery::modelo();      ?></th>
                        <th  align="center"><font size="-1"> <?php echo strtoupper('codigo_proveedor') ?></font></th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('proveedor') ?></font></th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('marca') ?></font></th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('caracteristicas') ?></font></th> 
                        <th  align="center"><font size="-1"><?php echo strtoupper('nombre') ?></font></th> 
                        <th  align="center"><font size="-1"><?php echo strtoupper('descripcion') ?></font></th> 
                        <th  align="center"><font size="-1"><?php echo strtoupper('nombre ingles') ?></font></th> 
                        <th  align="center"><font size="-1"><?php echo strtoupper('precio') ?></font></th> 
                        <th  align="center"><font size="-1"><?php echo strtoupper('costo') ?></font></th> 
                        <th  align="center"><font size="-1"><?php echo strtoupper('existencia') ?></font></th> 
                        <th  align="center"><font size="-1"><?php echo strtoupper('alto') ?></font></th> 
                        <th  align="center"><font size="-1"><?php echo strtoupper('ancho') ?></font></th> 
                        <th  align="center"><font size="-1"><?php echo strtoupper('largo') ?></font></th> 
                        <th  align="center"><font size="-1"><?php echo strtoupper('peso') ?></font></th> 
                        <th  align="center"><font size="-1"><?php echo strtoupper('costo fabrica') ?></font></th> 
                        <th  align="center"><font size="-1"><?php echo strtoupper('costo cif') ?></font></th>                       
                        <th  align="center"><font size="-1"></font></th>                   
                    </tr>

                </thead>
                <tbody>
                    <?php foreach ($datos as $registro) { ?>
                        <tr>
                            <td><font size="-3"><?php echo $registro['CODIGO_SKU'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['CODIGOBARRAS'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['CODIGO_ARANCEL'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['COD_GRUPO'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['GRUPO'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['COD_SUBGRUPO'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['SUBGRUPO'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['COD_PROVEEDOR'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['PROVEEDOR'] ?></font></td>                            
                            <td><font size="-3"><?php echo $registro['MARCA'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['CARACTERISTICAS'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['NOMBRE'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['DESCRIPCION'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['NOMBRE_INGLES'] ?></font></td>
                            <td  align="right"><font size="-3"><?php echo number_format($registro['PRECIO'], 2) ?></font></td>
                            <td><font size="-3"><?php echo $registro['COSTO'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['EXISTENCIA'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['ALTO'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['ANCHO'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['LARGO'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['PESO'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['COSTO_FABRICA'] ?></font></td>
                            <td><font size="-3"><?php echo $registro['COSTO_CIF'] ?></font></td>

                        </tr>    
                    <?php } ?>
                </tbody>
            </table>
            <hr>
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-7 note note-info note-bordered text-right"><p> Confirmar el listado de productos nuevos</p> </div>
                <div class="col-lg-2 ">

                    <a class="btn btn-primary btn-block btn-outline" href="<?php echo url_for($modulo . '/procesa?id=' . $id) ?>" >
                        <i class="fa fa-check "></i>
                        Procesar
                    </a>

                </div>
                <div class="col-lg-2"></div>

            </div>
        </div>

    </div>
</div>
