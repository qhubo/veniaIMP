<?php $modulo = $sf_params->get('module'); ?>

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
                        <th  align="center"><font size="-1"><?php echo strtoupper ('codigo_sku') ?></font>  </th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('codigo_barras') ?></font></th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('codigo_grupo') ?> </font><?php //echo TipoAparatoQuery::tipo();     ?> </th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('grupo') ?></font><?php //echo TipoAparatoQuery::tipo();     ?> </th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('codigo_subgrupo') ?></font><?php //echo TipoAparatoQuery::marca();     ?></th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('subgrupo') ?> </font><?php //echo TipoAparatoQuery::modelo();     ?></th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('codigo_categoria') ?></font></th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('categoria') ?></font></th> 
                        <th  align="center"><font size="-1"><?php echo strtoupper('nombre') ?></font></th> 
                        <th  align="center"><font size="-1"><?php echo strtoupper('descripcion') ?></font></th> 
                        <th  align="center"><font size="-1"><?php echo strtoupper('unidad') ?></font></th> 
                        <th  align="center"><font size="-1"><?php echo strtoupper('precio') ?></font></th> 
                        <th  align="center"><font size="-1"> <?php echo strtoupper('codigo_proveedor') ?></font></th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('proveedor') ?></font></th>
                        <th  align="center"><font size="-1"><?php echo strtoupper('unidad_costo') ?></font></th> 
                        <th  align="center"><font size="-1"><?php echo strtoupper('costo') ?></font></th> 
  <th  align="center"><font size="-1"></font></th> 

                   

                    </tr>
                    
                    <tr class="active">
                        <th  align="center"><font size="-2"> CODIGO SKU </font></th>
                        <th  align="center"><font size="-2">CODIGO BARRAS </font></th>
                        <th  align="center"><font size="-2">COD GRUPO </font><?php //echo TipoAparatoQuery::tipo();     ?> </th>
                        <th  align="center"><font size="-2">GRUPO </font><?php //echo TipoAparatoQuery::tipo();     ?> </th>
                        <th  align="center"><font size="-2">COD SUBGRUPO </font><?php //echo TipoAparatoQuery::marca();     ?></th>
                        <th  align="center"><font size="-2">SUBGRUPO </font><?php //echo TipoAparatoQuery::marca();     ?></th>
                        <th  align="center"><font size="-2">COD CATEGORIA </font> <?php //echo TipoAparatoQuery::modelo();     ?></th>
                        <th  align="center"><font size="-2">CATEGORIA </font> <?php //echo TipoAparatoQuery::modelo();     ?></th>
                        <th  align="center"><font size="-2">NOMBRE </font></th>
                        <th  align="center"><font size="-2">DESCRIPCION </font></th> 
                        <th  align="center"><font size="-2">UNIDAD </font> <?php //echo TipoAparatoQuery::modelo();     ?></th>

                        <th  align="center"><font size="-2">PRECIO </font><?php //echo TipoAparatoQuery::modelo();     ?></th>
                        <th  align="center"><font size="-2">COD PROVEEDOR </font> <?php //echo TipoAparatoQuery::modelo();     ?></th>
                        <th  align="center"><font size="-2">PROVEEDOR </font><?php //echo TipoAparatoQuery::modelo();     ?></th>
                          <th  align="center"><font size="-2">UNIDAD COSTO </font> <?php //echo TipoAparatoQuery::modelo();     ?></th>

                        <th  align="center"><font size="-2">COSTO </font> <?php //echo TipoAparatoQuery::modelo();     ?></th>
       <th  align="center"><font size="-2">CANTIDAD</font> <?php //echo TipoAparatoQuery::modelo();     ?></th>
   

            
                    </tr>
                </thead>
                <tbody>
          
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
