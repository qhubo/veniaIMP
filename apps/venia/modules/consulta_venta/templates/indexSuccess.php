<?php $modulo = $sf_params->get('module'); ?>

<div class="kt-portlet kt-portlet--responsive-mobile">

    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="flaticon2-graph kt-font-warning"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-info">
                Reporte de Ventas, Anulaciones y Notas de Crédito
                <small>Consolidado por rango de fechas</small>
            </h3>
        </div>
    </div>

    <div class="kt-portlet__body">

        <!-- 🔹 FORM -->
        <form method="POST" action="<?php echo url_for($modulo.'/index') ?>" class="form-horizontal">

            <?php echo $form->renderHiddenFields() ?>

            <div class="row">
                <div class="col-lg-3">
                    <label>Fecha Inicio</label>
                    <?php echo $form['fechaInicio'] ?>
                </div>

                <div class="col-lg-3">
                    <label>Fecha Fin</label>
                    <?php echo $form['fechaFin'] ?>
                </div>

                <div class="col-lg-2">
                    <label>Tienda</label>
                    <?php echo $form['bodega'] ?>
                </div>

                <div class="col-lg-2">
                    <label>Vendedor</label>
                    <?php echo $form['vendedor'] ?>
                </div>
            </div>

            <div class="row" style="margin-top:10px;">
                <div class="col-lg-3">
                    <label>Factura</label>
                    <?php echo $form['busqueda'] ?>
                </div>

                <div class="col-lg-2">
                    <label>Cliente</label>
                    <?php echo $form['cliente'] ?>
                </div>
                    
                <div class="col-lg-2 <?php if ($form['tipo_reporte']->hasError()) echo "has-error" ?>">
                    <label>Tipo Reporte</label>
                    <?php echo $form['tipo_reporte'] ?>           
                    <span class="help-block form-error"> 
                        <?php echo $form['tipo_reporte']->renderError() ?>  
                    </span>
                </div>
                <div class="col-lg-1">
                    
                    <br>
                    <button type="submit" class="btn btn-primary btn-block">
                        Buscar
                    </button>
                </div>
                  <div class="col-lg-1"><br><br>
                    <a target="_blank"
                       href="<?php echo url_for($modulo.'/reporteExcel') ?>"
                   class="btn  btn-sm btn-block " style="background-color:#04AA6D; color:white">
                    Excel
                    </a>
                </div>
            </div>

            <br>

            <div class="row">
                

              
            </div>

        </form>

        <hr>

        <!-- 🔥 TABLA -->
        <table class="table table-bordered table-condensed">
            <thead>
                <tr class="active">
                    <th>Código</th>
                    <th>Tienda</th>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Cliente</th>
                    <th>Nombre</th>
                    <th>RUC</th>
                    <th>Estado</th>
                    <th style="text-align:right">Valor</th>
                   
                    <th>Vendedor</th>
                          <th style="text-align:right">Pagado</th>
           
                </tr>
            </thead>

            <tbody>

                <?php 
                $TOTAL_VALOR = 0;
                $TOTAL_PAGADO = 0;
                ?>

                <?php foreach ($registros as $r) { ?>

                    <?php 
                    $TOTAL_VALOR += $r['valor'];
                    $TOTAL_PAGADO += $r['valor_pagado'];
                    ?>

                    <tr>

                        <td><?php echo $r['codigo'] ?></td>
                        <td><?php echo $r['codigo_tienda'] ?></td>
                        <td><?php echo $r['fecha'] ?></td>
                        <td><?php echo $r['usuario'] ?></td>
                        <td><?php echo $r['cliente'] ?></td>
                        <td><?php echo $r['nombre'] ?></td>
                        <td><?php echo $r['nit'] ?></td>

                        <td>
                            <?php if ($r['estatus'] == 'ANULADO') { ?>
                                <span class="label label-danger">ANULADO</span>
                            <?php } elseif ($r['estatus'] == 'NOTA CREDITO') { ?>
                                <span class="label label-warning">NOTA</span>
                            <?php } else { ?>
                                <span class="label label-success">VENTA</span>
                            <?php } ?>
                        </td>

                        <td style="text-align:right">
                            <?php echo Parametro::formato($r['valor']) ?>
                        </td>


                        <td><?php echo $r['vendedor'] ?></td>
                

                        <td style="text-align:right">
                            <?php echo Parametro::formato($r['valor_pagado']) ?>
                        </td>

                
                    </tr>

                <?php } ?>

            </tbody>

            <tfoot>
                <tr>
                    <th colspan="8">TOTALES</th>
                    <th style="text-align:right"><?php echo Parametro::formato($TOTAL_VALOR) ?></th>
                    <th colspan="1"></th>
                    <th style="text-align:right"><?php echo Parametro::formato($TOTAL_PAGADO) ?></th>
       
                </tr>
            </tfoot>

        </table>

    </div>
</div>