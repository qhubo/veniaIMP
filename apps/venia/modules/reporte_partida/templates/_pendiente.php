<?php $med=            sfContext::getInstance()->getUser()->getAttribute('med',null, 'consulta');; ?>     
<form action="<?php echo url_for($modulo . '/index?id=0') ?>" method="get">
            <div class="row">
                <div class="col-lg-2">Selección Tienda </div>
                <div class="col-lg-3">
                    <select  onchange="this.form.submit()" class="form-control"  name="med" id="med">
                        <option value="99">[Seleccione]</option>
                        <?php foreach ($tiendas as $lista) { ?>
                            <option <?php if ($med == $lista->getId()) { ?>  selected="selected"  <?php } ?>  value="<?php echo $lista->getId(); ?>"><?php echo $lista->getNombre(); ?></option>
                        <?php } ?>
                    </select>
                </div>
              

            </div>
        </form>

<table class="table table-bordered  dataTable table-condensed flip-content" >
    <thead class="flip-content">
        <tr class="info" style="background-color: #FFCC00 !important;">
            <th align="center" style="background-color: #FFCC00 !important;" >Fecha</th>
            <th align="center"  style="background-color: #FFCC00 !important;">Usuario</th>
            <th  align="center" style="background-color: #FFCC00 !important;"> Tipo</th>
            <th align="center" width="30px" style="background-color: #FFCC00 !important;"> Código</th>
             <th align="center" width="30px"> Asiento</th>
            <th  align="center" style="background-color: #FFCC00 !important;"> Valor</th>
            <th align="center"  style="text-align:center; background-color: #FFCC00 !important;"> Confirmar</th>
   
        </tr>
    </thead>
    <tbody>
        <?php $total = 0; ?>
        <?php foreach ($operaciones as $lista) { ?>
            <tr>

                <td><?php echo $lista->getFechaContable('d/m/Y'); ?></td>
                <td><?php echo $lista->getUsuario(); ?></td>
                <td><?php echo $lista->getTipo(); ?></td>
                <td>
                   <a href="<?php echo url_for("reporte_partida/partida?id=" . $lista->getId()) ?>" class="btn btn-block btn-sm btn-dark" data-toggle="modal" data-target="#ajaxmodalP<?php echo $lista->getId(); ?>">  <?php echo $lista->getCodigo(); ?>    </a>
                </td>
                  <td><?php echo $lista->getNoAsiento(); ?></td>
              <td style="text-align: right"><?php echo Parametro::formato($lista->getValor()); ?></td>
              <td style="align-content: center; text-align: center">
<!--           <a class="btn  btn-warning btn-small" data-toggle="modal" href="#ajaxmodalPartida<?php echo $lista->getId() ?>"><i class="fa fa-upload"></i>  Confirma </a>-->
                        <a href="<?php echo url_for("reporte_partida/confirma?id=" . $lista->getId()) ?>" class="btn  btn-warning btn-small"  data-toggle="modal" data-target="#ajaxmodalCon<?php echo $lista->getId(); ?>">  Confirmar   </a>
       
             
              </td>
      
    </tr>
<?php } ?>
</tbody>

</table>